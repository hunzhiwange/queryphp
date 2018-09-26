<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Common\App\Exception\Runtime;
use Common\App\Kernel;
use Leevel\Bootstrap\Project;
use Leevel\Http\Request;
use Leevel\Kernel\IKernel;
use Leevel\Kernel\Runtime\IRuntime;

/**
 * ---------------------------------------------------------------
 * Composer
 * ---------------------------------------------------------------.
 *
 * 用于管理 PHP 依赖包
 * 优化 composer 性能，提炼 composer 中的 autoload_static 中的我们关注的 psr4 命名空间映射
 * 我们 classmap 需要通过 `php leevel autoload` 生成，包含命令 `composer dump-autoload -o`
 * 对于助手函数需要自己引入
 */
$leevelAutoload = __DIR__.'/../runtime/autoload.php';

if (is_file($leevelAutoload)) {
    require_once $leevelAutoload;
} else {
    require_once __DIR__.'/../vendor/autoload.php';
}

/**
 * ---------------------------------------------------------------
 * 创建项目
 * ---------------------------------------------------------------.
 *
 * 注册项目基础服务
 */
$project = Project::singletons(realpath(__DIR__.'/..'));

$project->singleton(IKernel::class, Kernel::class);

$project->singleton(IRuntime::class, Runtime::class);

/**
 * ---------------------------------------------------------------
 * 执行项目
 * ---------------------------------------------------------------.
 *
 * 根据内核调度请求返回响应
 */
$kernel = $project->make(IKernel::class);

$response = $kernel->handle(
    $request = Request::createFromGlobals()
);

$response->send();

$kernel->terminate($request, $response);
