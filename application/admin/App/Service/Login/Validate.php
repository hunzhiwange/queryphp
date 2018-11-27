<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\App\Service\Login;

use Admin\Infra\Code;
use Common\Domain\Entity\App;
use Common\Domain\Entity\User;
use Leevel\Auth;
use Leevel\Auth\Hash;
use Leevel\Http\Request;
use Leevel\Kernel\HandleException;
use Leevel\Support\Str;
use Leevel\Validate as Validates;

/**
 * 验证登录.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.23
 *
 * @version 1.0
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
     * 构造函数.
     *
     * @param \Leevel\Http\Request $request
     * @param \Admin\Infra\Code    $code
     */
    public function __construct(Request $request, Code $code)
    {
        $this->request = $request;

        $this->code = $code;
    }

    /**
     * 响应方法.
     *
     * @param array $input
     *
     * @return array
     */
    public function handle(array $input): array
    {
        $this->input = $input;

        $this->validateArgs();

        $this->validateCode();

        $this->validateApp();

        $user = $this->validateUser();

        Auth::setTokenName($token = $this->createToken());

        Auth::login($userInfo = $user->toArray(['id', 'name', 'create_at']));

        return [
            'token'     => $token,
            'userInfo'  => $userInfo,
            'menusList' => [],
            'authList'  => [],
        ];
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
     */
    protected function validateApp()
    {
        $app = App::where('identity', $this->input['app_id'])->

        where('key', $this->input['app_key'])->

        findOne();

        $this->secret = $app->secret;

        if (!$app->id) {
            throw new HandleException(__('应用无法找到'));
        }
    }

    /**
     * 校验用户.
     *
     * @return \Common\Domain\Entity\User
     */
    protected function validateUser(): User
    {
        $user = User::Where('status', '1')->

        where('name', $this->input['name'])->

        findOne();

        if (!$user->id) {
            throw new HandleException(__('账号不存在或者已禁用'));
        }

        if (!$this->verifyPassword($this->input['password'], $user->password)) {
            throw new HandleException(__('账户密码错误'));
        }

        return $user;
    }

    /**
     * 对比验证码
     *
     * @param string $strInputCode
     * @param string $strCode
     * @param mixed  $code
     *
     * @return bool
     */
    protected function verifyPassword(string $password, string $hash): bool
    {
        return (new Hash())->verify($password, $hash);
    }

    /**
     * 校验验证码
     */
    protected function validateCode()
    {
        $codeFromCache = $this->code->get($this->input['name']);

        if (false === $codeFromCache) {
            return false;
        }

        if (strtoupper($this->input['code']) !== strtoupper($codeFromCache)) {
            throw new HandleException(__('验证码错误'));
        }
    }

    /**
     * 校验基本参数.
     */
    protected function validateArgs()
    {
        $validate = Validates::make(
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

        if ($validate->fail()) {
            throw new HandleException($validate->errorMessage());
        }
    }
}
