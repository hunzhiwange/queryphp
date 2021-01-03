<?php

declare(strict_types=1);

namespace App\Domain\Service\Login;

use Admin\Infra\Code;
use App\Domain\Entity\Base\App;
use App\Domain\Entity\User\User;
use App\Exceptions\AuthBusinessException;
use App\Exceptions\AuthErrorCode;
use Leevel\Auth\Hash;
use Leevel\Auth\Proxy\Auth;
use Leevel\Http\Request;
use Leevel\Support\Str;
use Leevel\Validate\Proxy\Validate as Validates;

/**
 * 验证登录.
 */
class Validate
{
    private array $input;

    /**
     * 秘钥.
     */
    private string $secret;

    public function __construct(private Request $request, private Code $code)
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

        $this->validateApp();

        $user = $this->validateUser();
        Auth::setTokenName($token = $this->createToken());
        Auth::login($user->toArray());

        return ['token' => $token];
    }

    /**
     * 生成 token.
     */
    private function createToken(): string
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

        return 'token:admin:'.hash_hmac('sha256', $token, $this->secret);
    }

    /**
     * 校验应用.
     *
     * @throws \App\Exceptions\AuthBusinessException
     */
    private function validateApp(): void
    {
        $app = App::select()
            ->where('num', $this->input['app_id'])
            ->where('key', $this->input['app_key'])
            ->findOne();
        if (!$app->id) {
            throw new AuthBusinessException(AuthErrorCode::APP_NOT_FOUND);
        }

        $this->secret = $app->secret;
    }

    /**
     * 校验用户.
     *
     * @throws \App\Exceptions\AuthBusinessException
     */
    private function validateUser(): User
    {
        $user = User::select()
            ->where('status', '1')
            ->where('name', $this->input['name'])
            ->findOne();
        if (!$user->id) {
            throw new AuthBusinessException(AuthErrorCode::ACCOUNT_NOT_EXIST_OR_DISABLED);
        }

        if (!$this->verifyPassword($this->input['password'], $user->password)) {
            throw new AuthBusinessException(AuthErrorCode::ACCOUNT_PASSWORD_ERROR);
        }

        return $user;
    }

    /**
     * 校验密码.
     */
    private function verifyPassword(string $password, string $hash): bool
    {
        return (new Hash())->verify($password, $hash);
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
