<?php

declare(strict_types=1);

namespace App\Auth\Service;

use App\Auth\Exceptions\AuthBusinessException;
use App\Auth\Exceptions\AuthErrorCode;
use App\Company\Entity\App;
use App\Infra\Code;
use App\User\Entity\User;
use Leevel\Auth\Proxy\Auth;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Encryption\Proxy\Encryption;
use Leevel\Http\Request;
use Leevel\Support\Str;

/**
 * 验证登录.
 */
class Login
{
    public function __construct(
        private Request $request,
        private Code $code,
        private UnitOfWork $w
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(LoginParams $params): array
    {
        $params->validate();
        $this->validateCode($params);
        $appSecret = $this->findAppSecret($params->appKey);
        $user = $this->validateUser($params->name, $params->password);
        Auth::setTokenName($this->createToken($params, $appSecret));
        $tmpAppSecret = $this->makeTmpAppSecret($params->appKey, $appSecret);

        $id = $user->id;
        $userData = $user->only([
            'type',
            'sub_type',
            'name',
            'num',
            'email',
            'mobile',
            'phone',
        ])->toArray();
        $userData['id'] = $id;

        $token = Auth::login($userData);

        return array_merge($tmpAppSecret, [
            'token' => $token,
        ]);
    }

    /**
     * 生成 token.
     */
    private function createToken(LoginParams $params, string $appSecret): string
    {
        $token = substr(
            md5(
                $this->request->server->get('HTTP_USER_AGENT').
                $this->request->server->get('SERVER_ADDR').
                $params->appKey.
                $params->name.
                $params->password.
                substr((string) time(), 0, 6)
            ),
            8,
            6
        ).
        Str::randAlphaNum(10);

        return 'token:'.hash_hmac('sha256', $token, $appSecret);
    }

    private function makeTmpAppSecret(string $appKey, string $appSecret): array
    {
        $authExpire = (int) \Leevel::env('AUTH_EXPIRE', 2592000);

        return [
            'tmp_app_key' => Encryption::encrypt($appKey, $authExpire),
            'tmp_app_secret' => Encryption::encrypt($appSecret, $authExpire),
        ];
    }

    /**
     * 查找应用秘钥.
     *
     * @throws \Exception
     */
    private function findAppSecret(string $appKey): string
    {
        return App::repository()->findAppSecretByKey($appKey);
    }

    /**
     * 校验用户.
     *
     * @throws \Exception
     */
    private function validateUser(string $name, string $password): User
    {
        $userRepository = User::repository();
        $user = $userRepository->findValidUserByName($name);
        $userRepository->verifyPassword($password, $user->password);

        return $user;
    }

    /**
     * 校验验证码.
     *
     * @throws \App\Auth\Exceptions\AuthBusinessException
     */
    private function validateCode(LoginParams $params): void
    {
        $codeFromCache = $this->code->get($params->name);
        if ('' === $codeFromCache) {
            return;
        }

        if (strtoupper($params->code) !== strtoupper($codeFromCache)) {
            throw new AuthBusinessException(AuthErrorCode::VERIFICATION_CODE_ERROR);
        }
    }
}
