<?php

declare(strict_types=1);

namespace App\Controller\Support;

use Leevel\Config\Proxy\Config;

/**
 * 关闭调试.
 */
trait CloseDebug
{
    private function closeDebug(): void
    {
        Config::set('debug', false);
    }
}
