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
 * 优化 composer 性能，优先载入 composer 注册的 Psr4
 * 如果 Psr4 不存在，才会去初始化 composer 加载，使得大部分请求不走 composer 的自动载入
 * 如果你使用的包是比较新的，基本都遵循 Psr4 规则，这个时候会提升一部分性能
 * 对于助手函数需要自己引入
 */
$psr4s = include_once __DIR__.'/../vendor/composer/autoload_psr4.php';

require_once __DIR__.'/../vendor/hunzhiwange/framework/src/Queryyetsimple/Bootstrap/function.php';

spl_autoload_register(function (string $className) use ($psr4s) {
    static $loadedComposer;

    $name = explode('\\', $className);
    $topLevel = '';

    for ($i = 0; $i <= 2; $i++) {
        $topLevel .= $name[$i].'\\';

        if (isset($psr4s[$topLevel])) {
            foreach ($psr4s[$topLevel] as $dir) {
                $file = $dir.'/'.str_replace('\\', '/', substr($className, strlen($topLevel))).'.php';

                if (is_file($file)) {
                    return require_once $file;
                }
            }
        }
    }

    if (null === $loadedComposer) {
        $composer = require_once __DIR__.'/../vendor/autoload.php';
        $composer->loadClass($className);
        $loadedComposer = true;
    }
});

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
