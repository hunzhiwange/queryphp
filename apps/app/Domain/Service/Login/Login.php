<?php

declare(strict_types=1);

namespace App\Domain\Service\Login;

use App\Domain\Entity\Base\App;
use App\Domain\Entity\User\User;
use App\Exceptions\AuthBusinessException;
use App\Exceptions\AuthErrorCode;
use App\Infra\Code;
use App\Infra\Repository\Base\App as AppReposity;
use App\Infra\Repository\User\User as UserReposity;
use Leevel\Auth\Proxy\Auth;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Http\Request;
use Leevel\Support\Str;
use Leevel\Validate\Proxy\Validate as Validates;

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

    public function handle(LoginParams $params): array
    {
        $this->validateArgs($params);

        // Mac 自带 PHP 有问题
        if (\function_exists('imagettftext')) {
            $this->validateCode($params);
        }

        $appSecret = $this->findAppSecret($params->appKey);
        $user = $this->validateUser($params->name, $params->password);
        Auth::setTokenName($token = $this->createToken($params, $appSecret));
        Auth::login($user->toArray());

        return ['token' => $token];
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

    /**
     * 查找应用秘钥.
     */
    private function findAppSecret(string $appKey): string
    {
        return $this
            ->appReposity()
            ->findAppSecretByKey($appKey);
    }

    private function appReposity(): AppReposity
    {
        return $this->w->repository(App::class);
    }

    /**
     * 校验用户.
     */
    private function validateUser(string $name, string $password): User
    {
        $userReposity = $this->userReposity();
        $user = $userReposity->findValidUserByName($name);
        $userReposity->verifyPassword($password, $user->password);

        return $user;
    }

    private function userReposity(): UserReposity
    {
        return $this->w->repository(User::class);
    }

    /**
     * 校验验证码.
     *
     * @throws \App\Exceptions\AuthBusinessException
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

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\AuthBusinessException
     */
    private function validateArgs(LoginParams $params): void
    {
        $params = $params->toArray();
        $validator = Validates::make(
            $params,
            [
                'app_key'  => 'required|alpha_dash',
                'name'     => 'required|chinese_alpha_num|max_length:50',
                'password' => 'required|chinese_alpha_dash|max_length:50',
                'code'     => 'required|alpha|min_length:4|max_length:4',
                'remember' => 'required',
            ],
            [
                'app_key'      => __('应用 KEY'),
                'name'         => __('用户名'),
                'password'     => __('密码'),
                'code'         => __('校验码'),
                'remember'     => __('保持登陆'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new AuthBusinessException(AuthErrorCode::AUTH_INVALID_ARGUMENT, $e, true);
        }
    }
}
