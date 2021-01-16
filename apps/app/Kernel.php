<?php

declare(strict_types=1);

namespace App;

use App\Middleware\Cors;
use Leevel\Debug\Middleware\Debug;
use Leevel\Kernel\IApp;
use Leevel\Kernel\Kernel as Kernels;
use Leevel\Log\Middleware\Log;
use Leevel\Router\IRouter;

class Kernel extends Kernels
{
    /**
     * 系统中间件.
     */
    protected array $middlewares = [
        Cors::class,
        Log::class,
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
