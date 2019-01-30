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
use Leevel\Kernel\IKernel;
use Leevel\Kernel\IKernelConsole;
use Leevel\Kernel\IRuntime;
use Leevel\Leevel\Project as BaseProject;

/**
 * 初始化应用.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2018.11.24
 *
 * @version 1.0
 */
trait Project
{
    /**
     * 初始化项目.
     *
     * @return \Leevel\Leevel\Project
     */
    protected function createProject(): BaseProject
    {
        require_once __DIR__.'/../vendor/autoload.php';

        $project = BaseProject::singletons(__DIR__.'/..');

        $project->singleton(IKernel::class, Kernel::class);

        $project->singleton(IKernelConsole::class, KernelConsole::class);

        $project->singleton(IRuntime::class, Runtime::class);

        $project->instance('request', Request::createFromGlobals());

        $project->make(IKernelConsole::class)->bootstrap();

        return $project;
    }
}
