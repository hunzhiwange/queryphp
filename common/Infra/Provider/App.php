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

use Admin\Infra\Permission;
use Admin\Infra\PermissionCache;
use Leevel\Di\IContainer;
use Leevel\Di\Provider;

/**
 * 应用服务提供者.
 */
class App extends Provider
{
    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->permission();
    }

    /**
     * {@inheritdoc}
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
    private function permission(): void
    {
        $this->container->singleton('permission', function (IContainer $container): Permission {
            /** @var \Leevel\Http\Request $request */
            $request = $container->make('request');
            $token = $request->query->get('token', '');

            return new Permission($container->make(PermissionCache::class), $token);
        });
    }
}
