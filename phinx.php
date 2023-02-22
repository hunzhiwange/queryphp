<?php

declare(strict_types=1);

use App\Infra\PhinxLoad;
use Leevel\Di\Container;
use Leevel\Kernel\App;
use Symfony\Component\Console\Input\ArgvInput;

// 加载 Composer
require __DIR__.'/vendor/autoload.php';

// 创建应用
$container = Container::singletons();
$app = new App($container, realpath(__DIR__));

// 载入环境
$input = new ArgvInput();
if ($input->hasParameterOption('--env')) {
    $env = $input->getParameterOption('--env');
} else {
    $env = 'env';
}
putenv('RUNTIME_ENVIRONMENT='.$env);

// 读取配置
(new PhinxLoad())->handle($app);

return [
    'paths' => [
        'migrations'    => 'assets/database/migrations',
        'seeds'         => 'assets/database/seeds',
    ],
    'environments'   => [
        'defaut_migration_table'    => 'phinxlog',
        'default_database'          => 'development',
        'production'                => [
            'adapter'   => 'mysql',
            'host'      => Leevel::env('DATABASE_HOST', 'localhost'),
            'name'      => Leevel::env('DATABASE_NAME', ''),
            'user'      => Leevel::env('DATABASE_USER', 'root'),
            'pass'      => Leevel::env('DATABASE_PASSWORD', ''),
            'port'      => Leevel::env('DATABASE_PORT', 3306),
            'charset'   => 'utf8',
        ],
        'development'   => [
            'adapter'   => 'mysql',
            'host'      => Leevel::env('DATABASE_HOST', 'localhost'),
            'name'      => Leevel::env('DATABASE_NAME', ''),
            'user'      => Leevel::env('DATABASE_USER', 'root'),
            'pass'      => Leevel::env('DATABASE_PASSWORD', ''),
            'port'      => Leevel::env('DATABASE_PORT', 3306),
            'charset'   => 'utf8',
        ],
        'env.phpunit'   => [
            'adapter'   => 'mysql',
            'host'      => Leevel::env('DATABASE_HOST', 'localhost'),
            'name'      => Leevel::env('DATABASE_NAME', ''),
            'user'      => Leevel::env('DATABASE_USER', 'root'),
            'pass'      => Leevel::env('DATABASE_PASSWORD', ''),
            'port'      => Leevel::env('DATABASE_PORT', 3306),
            'charset'   => 'utf8',
        ],
    ],
];
