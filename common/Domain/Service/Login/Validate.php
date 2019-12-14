<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Domain\Service\Login;

use Admin\Infra\Code;
use Admin\Infra\Permission;
use Common\Domain\Entity\Base\App;
use Common\Domain\Entity\User\User;
use Common\Domain\Service\User\User\UserPermission;
use Common\Infra\Exception\BusinessException;
use Leevel\Auth\Hash;
use Leevel\Auth\Proxy\Auth;
use Leevel\Http\IRequest;
use Leevel\Support\Str;
use Leevel\Validate\Proxy\Validate as Validates;

/**
 * 验证登录.
 */
class Validate
{
    /**
     * 验证码存储.
     *
     * @var \Admin\Infra\Code
     */
    protected $code;

    /**
     * 输入数据.
     *
     * @var array
     */
    protected $input;

    /**
     * 秘钥.
     *
     * @var string
     */
    protected $secret;

    /**
     * 权限缓存.
     *
     * @var \Admin\Infra\Permission
     */
    protected $permissionCache;

    /**
     * 获取用户权限.
     *
     * @var \Common\Domain\Service\User\User\UserPermission
     */
    protected $permission;

    /**
     * 构造函数.
     */
    public function __construct(IRequest $request, Code $code, Permission $permissionCache, UserPermission $permission)
    {
        $this->request = $request;
        $this->code = $code;
        $this->permissionCache = $permissionCache;
        $this->permission = $permission;
    }

    /**
     * 响应方法.
     */
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
    protected function createToken(): string
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
            8, 6
        ).
        Str::randAlphaNum(10);

        return hash_hmac('sha256', $token, $this->secret);
    }

    /**
     * 校验应用.
     *
     * @throws \Common\Infra\Exception\BusinessException
     */
    protected function validateApp(): void
    {
        $app = App::select()
            ->where('num', $this->input['app_id'])
            ->where('key', $this->input['app_key'])
            ->findOne();

        $this->secret = $app->secret;

        if (!$app->id) {
            throw new BusinessException(__('应用无法找到'));
        }
    }

    /**
     * 校验用户.
     *
     * @throws \Common\Infra\Exception\BusinessException
     */
    protected function validateUser(): User
    {
        $user = User::select()
            ->where('status', '1')
            ->where('name', $this->input['name'])
            ->findOne();

        if (!$user->id) {
            throw new BusinessException(__('账号不存在或者已禁用'));
        }

        if (!$this->verifyPassword($this->input['password'], $user->password)) {
            throw new BusinessException(__('账户密码错误'));
        }

        return $user;
    }

    /**
     * 校验密码
     */
    protected function verifyPassword(string $password, string $hash): bool
    {
        return (new Hash())->verify($password, $hash);
    }

    /**
     * 校验验证码.
     *
     * @throws \Common\Infra\Exception\BusinessException
     */
    protected function validateCode()
    {
        $codeFromCache = $this->code->get($this->input['name']);

        if (false === $codeFromCache) {
            return false;
        }

        if (strtoupper($this->input['code']) !== strtoupper($codeFromCache)) {
            throw new BusinessException(__('验证码错误'));
        }
    }

    /**
     * 校验基本参数.
     *
     * @throws \Common\Infra\Exception\BusinessException
     */
    protected function validateArgs()
    {
        $validator = Validates::make(
            $this->input,
            [
                'app_id'       => 'required|alpha_dash',
                'app_key'      => 'required|alpha_dash',
                'name'         => 'required|chinese_alpha_num|max_length:50',
                'password'     => 'required|chinese_alpha_dash|max_length:50',
                'code'         => 'required|alpha|min_length:4|max_length:4',
            ],
            [
                'app_id'       => __('应用 ID'),
                'app_key'      => __('应用 KEY'),
                'name'         => __('用户名'),
                'password'     => __('密码'),
                'code'         => __('校验码'),
            ]
        );

        if ($validator->fail()) {
            throw new BusinessException(json_encode($validator->error()));
        }
    }
}
