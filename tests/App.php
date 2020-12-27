<?php

declare(strict_types=1);

namespace Tests;

use App\Exceptions\Runtime;
use App\Kernel;
use App\KernelConsole;
use Leevel\Di\Container;
use Leevel\Di\IContainer;
use Leevel\Http\Request;
use Leevel\Kernel\App as KernelApp;
use Leevel\Kernel\IApp;
use Leevel\Kernel\Exceptions\IRuntime;
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
        $container->singleton(IRuntime::class, Runtime::class);

        $container->instance('request', Request::createFromGlobals());
        $container->alias('request', [Request::class, Request::class]);
        $container->make(IKernelConsole::class)->bootstrap();

        return $app;
    }
}
