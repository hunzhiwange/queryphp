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
use Leevel\Http\Request;
use Leevel\Kernel\App as BaseApp;
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
    protected function createApp(): BaseApp
    {
        $composer = require __DIR__.'/../vendor/autoload.php';

        $app = BaseApp::singletons(__DIR__.'/..');

        $app->setComposer($composer);

        $app->singleton(IKernel::class, Kernel::class);

        $app->singleton(IKernelConsole::class, KernelConsole::class);

        $app->singleton(IRuntime::class, Runtime::class);

        $app->instance('request', Request::createFromGlobals());

        $app->make(IKernelConsole::class)->bootstrap();

        return $app;
    }
}
