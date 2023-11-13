<?php

declare(strict_types=1);

use App\Infra\Exceptions\Runtime;
use App\Kernel;
use Leevel\Di\Container;
use Leevel\Di\IContainer;
use Leevel\Http\Request;
use Leevel\Kernel\App;
use Leevel\Kernel\Exceptions\IRuntime;
use Leevel\Kernel\IApp;
use Leevel\Kernel\IKernel;

// 加载 Composer
require_once __DIR__.'/../vendor/autoload.php';

// 创建应用
// 注册应用基础服务
$container = Container::singletons();
$container->singleton(IContainer::class, $container);

// 应用路径
$path = str_starts_with(__DIR__, 'phar://') ?
     Phar::running() :
     realpath(__DIR__.'/..');
$container->singleton('app', $app = new App($container, $path));

// PHAR 缓存路径不能是 phar 内部路径，因为 phar 内部路径是只读的
if (str_starts_with(__DIR__, 'phar://')) {
    $app->setStoragePath(substr(dirname(Phar::running()), 7).\DIRECTORY_SEPARATOR.'storage');
}

$container->alias('app', [IApp::class, App::class]);
$container->singleton(IKernel::class, Kernel::class);
$container->singleton(IRuntime::class, Runtime::class);

// 执行应用
// 根据内核调度请求返回响应
/** @var IKernel $kernel */
$kernel = $container->make(IKernel::class);
$response = $kernel->handle($request = Request::createFromGlobals());
$response->send();
$kernel->terminate($request, $response);
