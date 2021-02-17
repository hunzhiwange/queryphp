<?php

declare(strict_types=1);

namespace Admin\Controller\Support;

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
