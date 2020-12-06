<?php

declare(strict_types=1);

use Common\App\ExceptionRuntime;
use Common\App\Kernel;
use Leevel\Di\Container;
use Leevel\Di\IContainer;
use Leevel\Http\Request;
use Leevel\Kernel\App;
use Leevel\Kernel\IApp;
use Leevel\Kernel\IExceptionRuntime;
use Leevel\Kernel\IKernel;

// 加载 Composer
require __DIR__.'/../vendor/autoload.php';

// 创建应用
// 注册应用基础服务
$container = Container::singletons();
$container->singleton(IContainer::class, $container);
$container->singleton('app', new App($container, realpath(__DIR__.'/..')));
$container->alias('app', [IApp::class, App::class]);
$container->singleton(IKernel::class, Kernel::class);
$container->singleton(IExceptionRuntime::class, ExceptionRuntime::class);

// 执行应用
// 根据内核调度请求返回响应
$kernel = $container->make(IKernel::class);
$response = $kernel->handle($request = Request::createFromGlobals());
$response->send();
$kernel->terminate($request, $response);
