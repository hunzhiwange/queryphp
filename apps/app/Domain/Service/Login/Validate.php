<?php

declare(strict_types=1);

namespace App\Domain\Service\Login;

use Admin\Infra\Code;
use App\Domain\Entity\Base\App;
use App\Domain\Entity\User\User;
use App\Exceptions\AuthBusinessException;
use App\Exceptions\AuthErrorCode;
use Leevel\Auth\Proxy\Auth;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Http\Request;
use Leevel\Support\Str;
use Leevel\Validate\Proxy\Validate as Validates;
use App\Infra\Repository\User\User as UserReposity;
use App\Infra\Repository\Base\App as AppReposity;

/**
 * 验证登录.
 */
class Validate
{
    private array $input;

    public function __construct(
        private Request $request, 
        private Code $code, 
        private UnitOfWork $w
    ) 
    {
    }

    public function handle(array $input): array
    {
        $this->input = $input;
        $this->validateArgs();

        // Mac 自带 PHP 有问题
        if (\function_exists('imagettftext')) {
            $this->validateCode();
        }

        $appSecret = $this->findAppSecret();
        $user = $this->validateUser();
        Auth::setTokenName($token = $this->createToken($appSecret));
        Auth::login($user->toArray());

        return ['token' => $token];
    }

    /**
     * 生成 token.
     */
    private function createToken(string $appSecret): string
    {
        $token = substr(
            md5(
                $this->request->server->get('HTTP_USER_AGENT').
                $this->request->server->get('SERVER_ADDR').
                $this->input['app_id'].
                $this->input['app_key'].
                $this->input['name'].
                $this->input['password'].
                substr((string) time(), 0, 6)
            ),
            8,
            6
        ).
        Str::randAlphaNum(10);

        return 'token:admin:'.hash_hmac('sha256', $token, $appSecret);
    }

    /**
     * 查找应用秘钥.
     */
    private function findAppSecret(): string
    {
        return $this
            ->appReposity()
            ->findAppSecretByNumAndKey(
                $this->input['app_id'],
                $this->input['app_key'],
            );
    }

    private function appReposity(): AppReposity
    {
        return $this->w->repository(App::class);
    }

    /**
     * 校验用户.
     */
    private function validateUser(): User
    {
        $userReposity = $this->userReposity();
        $user = $userReposity->findValidUserByName($this->input['name']);
        $userReposity->verifyPassword($this->input['password'], $user->password);

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
    private function validateCode(): void
    {
        $codeFromCache = $this->code->get($this->input['name']);
        if ('' === $codeFromCache) {
            return;
        }

        if (strtoupper($this->input['code']) !== strtoupper($codeFromCache)) {
            throw new AuthBusinessException(AuthErrorCode::VERIFICATION_CODE_ERROR);
        }
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\AuthBusinessException
     */
    private function validateArgs(): void
    {
        $validator = Validates::make(
            $this->input,
            [
                'app_id'   => 'required|alpha_dash',
                'app_key'  => 'required|alpha_dash',
                'name'     => 'required|chinese_alpha_num|max_length:50',
                'password' => 'required|chinese_alpha_dash|max_length:50',
                'code'     => 'required|alpha|min_length:4|max_length:4',
            ],
            [
                'app_id'       => __('应用 ID'),
                'app_key'      => __('应用 KEY'),
                'name'         => __('用户名'),
                'password' => __('密码'),
                'code'         => __('校验码'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);
            throw new AuthBusinessException(AuthErrorCode::AUTH_INVALID_ARGUMENT, $e, true);
        }
    }
}
