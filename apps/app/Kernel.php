<?php

declare(strict_types=1);

namespace App;

use App\Middleware\Cors;
use Leevel\Kernel\Kernel as Kernels;

class Kernel extends Kernels
{
    /**
     * 系统中间件.
     */
    protected array $middlewares = [
        Cors::class,
    ];
}
