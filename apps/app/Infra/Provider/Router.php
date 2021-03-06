<?php

declare(strict_types=1);

namespace App\Infra\Provider;

use Admin\Middleware\Auth as AdminAuth;
use Leevel\Router\RouterProvider;
use Leevel\Session\Middleware\Session;
use Leevel\Throttler\Middleware\Throttler;

/**
 * 路由服务提供者.
 */
class Router extends RouterProvider
{
    /**
     * 控制器相对目录.
     */
    protected ?string $controllerDir = 'Controller';

    /**
     * 中间件分组.
     *
     * - 分组可以很方便地批量调用组件.
     */
    protected array $middlewareGroups = [
        // web 请求中间件
        'web' => [
            'session',
        ],

        // api 请求中间件
        'api' => [
            // API 限流，可以通过网关来做限流更高效，如果需要去掉注释即可
            // 'throttler:60,60',
        ],
    ];

    /**
     * 中间件别名.
     *
     * - HTTP 中间件提供一个方便的机制来过滤进入应用程序的 HTTP 请求.
     * - 例外在应用执行结束后响应环节也会调用 HTTP 中间件.
     */
    protected array $middlewareAlias = [
        'admin_auth' => AdminAuth::class,
        'session'           => Session::class,
        'throttler'         => Throttler::class,
    ];

    /**
     * 基础路径.
     */
    protected array $basePaths = [
        'api/test' => [
            'middlewares' => 'api',
        ],
        ':admin/*' => [
            'middlewares' => 'admin_auth',
        ],
    ];

    /**
     * 分组.
     */
    protected array $groups = [
        'pet'     => [],
        'store'   => [],
        'user'    => [],
        '/api/v1' => [
            'middlewares' => 'api',
        ],
        'api/v2' => [
            'middlewares' => 'api',
        ],
        '/web/v1' => [
            'middlewares' => 'web',
        ],
        'web/v2' => [
            'middlewares' => 'web',
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function bootstrap(): void
    {
        parent::bootstrap();
    }

    /**
     * {@inheritDoc}
     */
    public function getRouters(): array
    {
        return parent::getRouters();
    }
}
