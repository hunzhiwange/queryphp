<?php

declare(strict_types=1);

use App\Exceptions\Runtime;
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
