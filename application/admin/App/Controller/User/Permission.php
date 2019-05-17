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

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\User\Permission as Service;
use Leevel\Auth\Proxy\Auth;
use Leevel\Http\IRequest;

/**
 * 用户权限获取.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.22
 *
 * @version 1.0
 */
class Permission
{
    use Controller;

    /**
     * 允许的输入字段.
     *
     * @var array
     */
    private $allowedInput = [
        'token',
        'refresh',
    ];

    /**
     * 响应方法.
     *
     * @param \Leevel\Http\IRequest              $request
     * @param \Admin\App\Service\User\Permission $service
     *
     * @return array
     */
    public function handle(IRequest $request, Service $service): array
    {
        return $this->main($request, $service);
    }

    /**
     * 扩展输入数据.
     *
     * @param \Leevel\Http\IRequest $request
     *
     * @return array
     */
    private function extendInput(IRequest $request): array
    {
        return ['id' => $this->id()];
    }

    /**
     * 获取用户 ID.
     *
     * @return int
     */
    private function id(): int
    {
        return (int) Auth::getLogin()['id'];
    }
}
