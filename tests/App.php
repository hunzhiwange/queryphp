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

use Common\App\Exception\Runtime;
use Common\App\Kernel;
use Common\App\KernelConsole;
use Composer\Autoload\ClassLoader;
use Leevel\Di\Container;
use Leevel\Di\IContainer;
use Leevel\Http\IRequest;
use Leevel\Http\Request;
use Leevel\Kernel\App as KernelApp;
use Leevel\Kernel\IApp;
use Leevel\Kernel\IKernel;
use Leevel\Kernel\IKernelConsole;
use Leevel\Kernel\IRuntime;

/**
 * 初始化应用.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2018.11.24
 *
 * @version 1.0
 */
trait App
{
    /**
     * 初始化应用.
     *
     * @return \Leevel\Kernel\App
     */
    protected function createApp(): KernelApp
    {
        $composer = require __DIR__.'/../vendor/autoload.php';

        $container = Container::singletons();
        $container->singleton(IContainer::class, $container);

        $container->singleton('composer', $composer);
        $container->alias('composer', ClassLoader::class);

        $container->singleton('app', $app = new KernelApp($container, realpath(__DIR__.'/..')));
        $container->alias('app', [IApp::class, KernelApp::class]);

        $container->singleton(IKernel::class, Kernel::class);
        $container->singleton(IKernelConsole::class, KernelConsole::class);
        $container->singleton(IRuntime::class, Runtime::class);

        $container->instance('request', Request::createFromGlobals());
        $container->alias('request', [IRequest::class, Request::class]);

        $container->make(IKernelConsole::class)->bootstrap();

        return $app;
    }
}
