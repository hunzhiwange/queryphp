<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use Common\App\ExceptionRuntime;
use Common\App\Kernel;
use Common\App\KernelConsole;
use Leevel\Di\Container;
use Leevel\Di\IContainer;
use Leevel\Http\Request;
use Leevel\Kernel\App as KernelApp;
use Leevel\Kernel\IApp;
use Leevel\Kernel\IExceptionRuntime;
use Leevel\Kernel\IKernel;
use Leevel\Kernel\IKernelConsole;

/**
 * 初始化应用.
 */
trait App
{
    /**
     * 初始化应用.
     */
    protected function createApp(): KernelApp
    {
        require __DIR__.'/../vendor/autoload.php';

        $container = Container::singletons();
        $container->singleton(IContainer::class, $container);

        $container->singleton('app', $app = new KernelApp($container, realpath(__DIR__.'/..')));
        $container->alias('app', [IApp::class, KernelApp::class]);

        $container->singleton(IKernel::class, Kernel::class);
        $container->singleton(IKernelConsole::class, KernelConsole::class);
        $container->singleton(IExceptionRuntime::class, ExceptionRuntime::class);

        $container->instance('request', Request::createFromGlobals());
        $container->alias('request', [Request::class, Request::class]);
        $container->make(IKernelConsole::class)->bootstrap();

        return $app;
    }
}
