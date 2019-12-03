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

namespace Common\Infra\Provider;

use Admin\Infra\Auth;
use Admin\Infra\Permission;
use Leevel\Di\IContainer;
use Leevel\Di\Provider;

/**
 * 应用服务提供者.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.01.29
 *
 * @version 1.0
 */
class App extends Provider
{
    /**
     * 注册服务.
     */
    public function register(): void
    {
        $this->permission();
    }

    /**
     * 可用服务提供者.
     */
    public static function providers(): array
    {
        return [
            'permission',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function isDeferred(): bool
    {
        return true;
    }

    /**
     * 注册 permission 服务.
     */
    protected function permission(): void
    {
        $this->container->singleton('permission', function (IContainer $container) {
            $token = $container->make('request')->query->get('token', '');

            return new Auth($container->make(Permission::class), $token);
        });
    }
}
