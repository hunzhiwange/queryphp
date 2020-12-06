<?php

declare(strict_types=1);

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
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->permission();
    }

    /**
     * {@inheritDoc}
     */
    public static function providers(): array
    {
        return [
            'permission',
        ];
    }

    /**
     * {@inheritDoc}
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
