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

namespace Admin\App\Controller\User;

use Admin\App\Service\User\Unlock as service;
use Leevel\Auth;
use Leevel\Http\Request;

/**
 * 解锁.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.21
 *
 * @version 1.0
 */
class Unlock
{
    /**
     * 响应方法.
     *
     * @param \Leevel\Http\Request           $request
     * @param \Admin\App\Service\User\Unlock $service
     *
     * @return array
     */
    public function handle(Request $request, Service $service): array
    {
        return $service->handle(array_merge(['token' => $this->token(), 'id' => $this->id()], $this->input($request)));
    }

    /**
     * 获取 Token.
     *
     * @return string
     */
    protected function token(): string
    {
        return Auth::getTokenName();
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
     * @param \Leevel\Http\Request $request
     *
     * @return array
     */
    protected function input(Request $request): array
    {
        return $request->only([
            'password',
        ]);
    }
}
