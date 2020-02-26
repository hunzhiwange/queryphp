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

use Leevel\Di\IContainer;
use Leevel\Router\RouterProvider;

/**
 * 路由服务提供者.
 */
class Router extends RouterProvider
{
    /**
     * 控制器相对目录.
     *
     * @var string
     */
    protected string $controllerDir = 'App\\Controller';

    /**
     * 中间件分组.
     *
     * - 分组可以很方便地批量调用组件.
     *
     * @var array
     */
    protected array $middlewareGroups = [
        // web 请求中间件
        'web' => [
            'session',
        ],

        // api 请求中间件
        'api' => [
            // API 限流，可以通过网关来做限流更高效，如果需要去掉注释即可
            // 'throttler:60,1',
        ],

        // 公共请求中间件
        'common' => [
            'log',
        ],
    ];

    /**
     * 中间件别名.
     *
     * - HTTP 中间件提供一个方便的机制来过滤进入应用程序的 HTTP 请求
     * - 例外在应用执行结束后响应环节也会调用 HTTP 中间件.
     *
     * @var array
     */
    protected array $middlewareAlias = [
        'auth'              => 'Leevel\\Auth\\Middleware\\Auth',
        'cors'              => 'Admin\\App\\Middleware\\Cors',
        'admin_auth'        => 'Admin\\App\\Middleware\\Auth',
        'debug'             => 'Leevel\\Debug\\Middleware\\Debug',
        'log'               => 'Leevel\\Log\\Middleware\\Log',
        'session'           => 'Leevel\\Session\\Middleware\\Session',
        'throttler'         => 'Leevel\\Throttler\\Middleware\\Throttler',
    ];

    /**
     * 基础路径.
     *
     * @var array
     */
    protected array $basePaths = [
        '*' => [
            'middlewares' => 'common',
        ],
        'foo/*world' => [
        ],
        'api/test' => [
            'middlewares' => 'api',
        ],
        ':admin/*' => [
            'middlewares' => 'admin_auth,cors',
        ],
        'options/index' => [
            'middlewares' => 'cors',
        ],
        'admin/show' => [
            'middlewares' => 'auth',
        ],
    ];

    /**
     * 分组.
     *
     * @var array
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
     * 创建一个服务容器提供者实例.
     */
    public function __construct(IContainer $container)
    {
        parent::__construct($container);

        if ($container->make('app')->isDebug()) {
            $this->middlewareGroups['common'][] = 'debug';
        }
    }

    /**
     * bootstrap.
     */
    public function bootstrap(): void
    {
        parent::bootstrap();
    }

    /**
     * 返回路由.
     */
    public function getRouters(): array
    {
        return parent::getRouters();
    }
}
