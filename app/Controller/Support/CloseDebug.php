<?php

declare(strict_types=1);

namespace App\Controller\Support;

use Leevel\Option\Proxy\Option;

/**
 * 关闭调试.
 */
trait CloseDebug
{
    private function closeDebug(): void
    {
        Option::set('debug', false);
    }
}
