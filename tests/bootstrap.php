<?php

declare(strict_types=1);

use App\Company\Service\InjectCommonData;
use App\Infra\Exceptions\Runtime;
use App\Kernel;
use App\KernelConsole;
use Leevel\Di\Container;
use Leevel\Di\IContainer;
use Leevel\Http\Request;
use Leevel\Kernel\App as KernelApp;
use Leevel\Kernel\Exceptions\IRuntime;
use Leevel\Kernel\IApp;
use Leevel\Kernel\IKernel;
use Leevel\Kernel\IKernelConsole;

error_reporting(E_ALL);

ini_set('xdebug.max_nesting_level', '200');
ini_set('memory_limit', '512M');

$vendorDir = __DIR__.'/../vendor';

require_once __DIR__.'/function.php';

if (false === is_file($vendorDir.'/autoload.php')) {
    throw new Exception('You must set up the app dependencies, run the following commands:
        wget http://getcomposer.org/composer.phar
        php composer.phar install');
}

include $vendorDir.'/autoload.php';

// 检查是否为开发环境，生产环境无法运行测试用例
if (!class_exists('Tests\\TestCase')) {
    throw new \Exception('You must set up the app dependencies, run the following commands:
        php leevel development');
}

// 注册 PHPUNIT 友好提示
(new \NunoMaduro\Collision\Provider())->register();

$container = Container::singletons();
$container->singleton(IContainer::class, $container);

// @phpstan-ignore-next-line
$container->singleton('app', $app = new KernelApp($container, realpath(__DIR__.'/..')));
$container->alias('app', [IApp::class, KernelApp::class]);

$container->singleton(IKernel::class, Kernel::class);
$container->singleton(IKernelConsole::class, KernelConsole::class);
$container->singleton(IRuntime::class, Runtime::class);

$container->instance('request', Request::createFromGlobals());
$container->alias('request', [Request::class, Request::class]);
// @phpstan-ignore-next-line
$container->make(IKernelConsole::class)->bootstrap();

// 注入平台和公司信息
(new \App\Company\Service\InjectPlatformCompany())->handle(100000, 100100);

// 注入账号信息
(new \App\Company\Service\InjectAccount())->handle(4145731145437184, 'admin');

// 注入公共信息
(new InjectCommonData())->handle();
