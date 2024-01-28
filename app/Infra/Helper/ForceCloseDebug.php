<?php

declare(strict_types=1);

namespace App\Infra\Helper;

use Leevel\Config\Proxy\Config;

/**
 * 强制关闭调试模式.
 */
class ForceCloseDebug
{
    public static function handle(): void
    {
        Config::set('debug', false);
    }
}
