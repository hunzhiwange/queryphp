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

namespace Admin\App\Controller\User;

use Admin\App\Service\User\ChangePassword as service;
use Leevel\Auth\Facade\Auth;
use Leevel\Http\IRequest;

/**
 * 用户修改密码.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.21
 *
 * @version 1.0
 */
class ChangePassword
{
    /**
     * 响应方法.
     *
     * @param \Leevel\Http\IRequest                  $request
     * @param \Admin\App\Service\User\ChangePassword $service
     *
     * @return array
     */
    public function handle(IRequest $request, Service $service): array
    {
        return $service->handle(array_merge(['id' => $this->id()], $this->input($request)));
    }

    /**
     * 获取用户 ID.
     *
     * @return int
     */
    protected function id(): int
    {
        return (int) Auth::getLogin()['id'];
    }

    /**
     * 输入数据.
     *
     * @param \Leevel\Http\IRequest $request
     *
     * @return array
     */
    protected function input(IRequest $request): array
    {
        return $request->only([
            'old_pwd',
            'new_pwd',
            'confirm_pwd',
        ]);
    }
}
