<?php

declare(strict_types=1);

namespace App\Domain\Service\Login;

use App\Domain\Entity\Base\App;
use App\Domain\Entity\User\User;
use App\Exceptions\AuthBusinessException;
use App\Exceptions\AuthErrorCode;
use App\Infra\Code;
use App\Infra\Repository\Base\App as AppRepository;
use App\Infra\Repository\User\User as UserRepository;
use Leevel\Auth\Proxy\Auth;
use Leevel\Database\Ddd\UnitOfWork;
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
     *
     * @throws \Exception
     */
    private function findAppSecret(string $appKey): string
    {
        return $this
            ->appRepository()
            ->findAppSecretByKey($appKey)
        ;
    }

    private function appRepository(): AppRepository
    {
        return $this->w->repository(App::class);
    }

    /**
     * 校验用户.
     */
    private function validateUser(string $name, string $password): User
    {
        $userRepository = $this->userRepository();
        $user = $userRepository->findValidUserByName($name);
        $userRepository->verifyPassword($password, $user->password);

        return $user;
    }

    private function userRepository(): UserRepository
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
}
