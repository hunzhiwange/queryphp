<?php

declare(strict_types=1);

namespace App;

use App\Infra\Bootstrap\CorsHeaders;
use Leevel\Kernel\KernelConsole as KernelConsoles;

class KernelConsole extends KernelConsoles
{
    /**
     * 应用扩展初始化执行.
     */
    protected array $extendBootstraps = [
        CorsHeaders::class,
    ];
}
