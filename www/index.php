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

use Common\App\Exception\Runtime;
use Common\App\Kernel;
use Composer\Autoload\ClassLoader;
use Leevel\Di\Container;
use Leevel\Di\IContainer;
use Leevel\Http\Request;
use Leevel\Kernel\App;
use Leevel\Kernel\IApp;
use Leevel\Kernel\IKernel;
use Leevel\Kernel\IRuntime;

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
$autoloadLeevel = __DIR__.'/../vendor/autoloadLeevel.php';

if (is_file($autoloadLeevel)) {
    $composer = require $autoloadLeevel;
} else {
    $composer = require __DIR__.'/../vendor/autoload.php';
}

/**
 * ---------------------------------------------------------------
 * 创建应用
 * ---------------------------------------------------------------.
 *
 * 注册应用基础服务
 */
$container = Container::singletons();
$container->singleton(IContainer::class, $container);

$container->singleton('composer', $composer);
$container->alias('composer', ClassLoader::class);

$container->singleton('app', new App($container, realpath(__DIR__.'/..')));
$container->alias('app', [IApp::class, App::class]);

$container->singleton(IKernel::class, Kernel::class);

$container->singleton(IRuntime::class, Runtime::class);

/**
 * ---------------------------------------------------------------
 * 执行应用
 * ---------------------------------------------------------------.
 *
 * 根据内核调度请求返回响应
 */
$kernel = $container->make(IKernel::class);

$response = $kernel->handle(
    $request = Request::createFromGlobals()
);

$response->send();

$kernel->terminate($request, $response);
