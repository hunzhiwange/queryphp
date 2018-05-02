<?php
// (c) 2018 http://your.domain.com All rights reserved.

use Leevel\Http\Request;
use Leevel\Bootstrap\{
    Project,
    IKernel,
    Runtime\IRuntime
};
use Common\App\{
    Kernel,
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
 * 导入项目
 * ---------------------------------------------------------------
 *
 * 用于管理 PHP 依赖包
 * 注册异常
 */
$project = Project::singletons(realpath(__DIR__ . '/..'));

$project->singleton(IKernel::class, Kernel::class);

$project->singleton(IRuntime::class, Runtime::class);

/**
 * ---------------------------------------------------------------
 * 执行项目
 * ---------------------------------------------------------------
 *
 * 用于管理 PHP 依赖包
 */

$kernel = $project->make(IKernel::class);

$response = $kernel->handle(
    $request = Request::createFromGlobals()
);

$response->send();

$kernel->terminate($request, $response);
