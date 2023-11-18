<?php

declare(strict_types=1);

namespace App;

use App\Infra\Bootstrap\CorsHeaders;
use App\Infra\Middleware\Cors;
use App\Infra\Middleware\Filter;
use Leevel\Debug\Middleware\Debug;
use Leevel\Kernel\IApp;
use Leevel\Kernel\Kernel as Kernels;
use Leevel\Router\IRouter;

class Kernel extends Kernels
{
    /**
     * 系统中间件.
     */
    protected array $middlewares = [
        Cors::class,
        Filter::class,
    ];

    /**
     * 应用扩展初始化执行.
     */
    protected array $extendBootstraps = [
        CorsHeaders::class,
    ];

    /**
     * {@inheritDoc}
     */
    public function __construct(IApp $app, IRouter $router)
    {
        if ($app->isDebug()) {
            $this->middlewares[] = Debug::class;
        }

        parent::__construct($app, $router);
    }
}
