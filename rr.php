<?php

declare(strict_types=1);

use App\Infra\Exceptions\Runtime;
use App\Infra\RoadRunnerServer;
use App\Kernel;
use Leevel\Di\Container;
use Leevel\Di\IContainer;
use Leevel\Kernel\App;
use Leevel\Kernel\Exceptions\IRuntime;
use Leevel\Kernel\IApp;
use Leevel\Kernel\IKernel;

// 加载 Composer
require __DIR__.'/vendor/autoload.php';

// 创建应用
// 注册应用基础服务
$container = Container::singletons();
$container->singleton(IContainer::class, $container);
$container->singleton('app', $app = new App($container, realpath(__DIR__)));
$container->alias('app', [IApp::class, App::class]);
$container->singleton(IKernel::class, Kernel::class);
$container->singleton(IRuntime::class, Runtime::class);

// 处理请求
(new RoadRunnerServer())->handle($app);
