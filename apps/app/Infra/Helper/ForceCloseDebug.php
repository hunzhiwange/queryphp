<?php

declare(strict_types=1);

namespace App\Infra\Helper;

use Leevel\Option\Proxy\Option;

/**
 * 强制关闭调试模式.
 */
class ForceCloseDebug
{
    public static function handle(): void
    {
        Option::set('debug', false);
    }
}
