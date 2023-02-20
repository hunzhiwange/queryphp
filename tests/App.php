<?php

declare(strict_types=1);

namespace Tests;

use Leevel\Di\Container;
use Leevel\Kernel\App as KernelApp;

trait App
{
    /**
     * 初始化应用.
     *
     * @todo 修改为 \Leevel\Kernel\IApp
     */
    protected function createApp(): KernelApp
    {
        // @phpstan-ignore-next-line
        return Container::singletons()->make('app');
    }
}
