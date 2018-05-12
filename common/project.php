<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.

use Leevel\Bootstrap\Project;
use Leevel\Kernel\{
    IKernel,
    IKernelConsole,
    Runtime\IRuntime
};
use Common\App\{
    Kernel,
    KernelConsole,
    Exception\Runtime
};

/**
 * ---------------------------------------------------------------
 * Composer
 * ---------------------------------------------------------------
 *
 * 用于管理 PHP 依赖包
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * ---------------------------------------------------------------
 * 创建项目
 * ---------------------------------------------------------------
 *
 * 注册项目基础服务
 */
$project = Project::singletons(realpath(__DIR__ . '/..'));

$project->singleton(IKernel::class, Kernel::class);

$project->singleton(IKernelConsole::class, KernelConsole::class);

$project->singleton(IRuntime::class, Runtime::class);

return $project;
