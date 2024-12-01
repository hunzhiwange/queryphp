<?php

declare(strict_types=1);

namespace App\Infra\Helper;

use Leevel\Config\Proxy\Config;
use Leevel\Debug\Debug;

/**
 * 强制关闭调试模式.
 */
class ForceCloseDebug
{
    protected static bool $debug = false;

    protected static bool $debugBar = false;

    public static function handle(): void
    {
        static::$debug = (bool) Config::proxy()->get('debug');
        Config::proxy()->set('debug', false);

        $debugBar = static::getDebugBar();
        static::$debugBar = $debugBar->getDebugStatus();
        $debugBar->disable();
    }

    public static function restore(): void
    {
        Config::set('debug', static::$debug);

        $debugBar = static::getDebugBar();
        if (static::$debugBar) {
            $debugBar->enable();
        } else {
            $debugBar->disable();
        }
    }

    protected static function getDebugBar(): Debug
    {
        // @phpstan-ignore-next-line
        return \App::proxy()->make(Debug::class);
    }
}
