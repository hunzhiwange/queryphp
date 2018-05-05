<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace Common\Infra\Provider;

use Leevel\Router\RouterProvider;
use Leevel\Router\ScanSwaggerRouter;

/**
 * 路由服务提供者
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2018.04.17
 * @version 1.0
 */
class Router extends RouterProvider
{

    /**
     * 控制器相对目录
     * 
     * @var string
     */
    protected $controllerDir = 'App\Controller';

    /**
     * 中间件分组
     * 分组可以很方便地批量调用组件
     *
     * @var array
     */
    protected $middlewareGroups = [
        // web 请求中间件
        'web' => [
            'session',
            'log'
        ],

        // api 请求中间件
        'api' => [
            'throttler:60,1',
            'log'
        ],

        // console 请求中间件
        'console' => [
            'log'
        ],
    ];

    /**
     * 中间件别名
     * HTTP 中间件提供一个方便的机制来过滤进入应用程序的 HTTP 请求
     * 例外在应用执行结束后响应环节也会调用 HTTP 中间件
     *
     * @var array
     */
    protected $middlewareAlias = [
        'session' => 'Leevel\Session\Middleware\Session',
        'throttler' => 'Leevel\Throttler\Middleware\Throttler',
        'log' => 'Leevel\Log\Middleware\Log'
    ];


    /**
     * bootstrap
     *
     * @return void
     */
    public function bootstrap()
    {
        parent::bootstrap();
    }

    /**
     * 返回路由
     *
     * @return array
     */
    public function getRouters() {
        return (new ScanSwaggerRouter($this->makeMiddlewareParser()))->handle();
    }

    /**
     * 全局中间件
     *
     * @return array
     */
    public function getMiddlewares() {
        if (api()) {
            return ['api'];
        } elseif (console()) {
            return ['console'];
        } else {
            return ['web'];
        }
    }
}
