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
$app = new App($container, (string) realpath(__DIR__));

// 载入环境
$input = new ArgvInput();
if ($input->hasParameterOption('--env')) {
    $env = $input->getParameterOption('--env');
} else {
    $env = 'env';
}
putenv('RUNTIME_ENVIRONMENT='.$env);

// 选择数据库
if ($input->hasParameterOption('--database')) {
    $database = $input->getParameterOption('--database');
} else {
    $database = 'development';
}

if ($input->hasParameterOption('--database-index')) {
    $databaseIndex = (string) $input->getParameterOption('--database-index');
} else {
    $databaseIndex = '';
}

if (!in_array($database, [
    'production',
    'production_common',
    'development',
    'development_common',
], true)) {
    throw new \Exception('Database must be one of `production,production_common,development,development_common`.');
}

// 读取配置
(new PhinxLoad())->handle($app);

$migrationPath = str_contains($database, '_common') ? 'common' : 'data';

return [
    'paths' => [
        'migrations' => "assets/database/{$migrationPath}/migrations",
        'seeds' => "assets/database/{$migrationPath}/seeds",
    ],
    'environments' => [
        'default_migration_table' => 'phinx_log',
        'default_database' => $database,
        'production' => [
            'adapter' => 'mysql',
            'host' => Leevel::env('DATABASE_HOST', 'localhost'),
            'name' => Leevel::env('DATABASE_NAME', '').$databaseIndex,
            'user' => Leevel::env('DATABASE_USER', 'root'),
            'pass' => Leevel::env('DATABASE_PASSWORD', ''),
            'port' => Leevel::env('DATABASE_PORT', 3306),
            'charset' => 'utf8',
        ],
        'production_common' => [
            'adapter' => 'mysql',
            'host' => Leevel::env('DATABASE_COMMON_HOST', 'localhost'),
            'name' => Leevel::env('DATABASE_COMMON_NAME', ''),
            'user' => Leevel::env('DATABASE_COMMON_USER', 'root'),
            'pass' => Leevel::env('DATABASE_COMMON_PASSWORD', ''),
            'port' => Leevel::env('DATABASE_COMMON_PORT', 3306),
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => Leevel::env('DATABASE_HOST', 'localhost'),
            'name' => Leevel::env('DATABASE_NAME', '').$databaseIndex,
            'user' => Leevel::env('DATABASE_USER', 'root'),
            'pass' => Leevel::env('DATABASE_PASSWORD', ''),
            'port' => Leevel::env('DATABASE_PORT', 3306),
            'charset' => 'utf8',
        ],
        'development_common' => [
            'adapter' => 'mysql',
            'host' => Leevel::env('DATABASE_COMMON_HOST', 'localhost'),
            'name' => Leevel::env('DATABASE_COMMON_NAME', ''),
            'user' => Leevel::env('DATABASE_COMMON_USER', 'root'),
            'pass' => Leevel::env('DATABASE_COMMON_PASSWORD', ''),
            'port' => Leevel::env('DATABASE_COMMON_PORT', 3306),
            'charset' => 'utf8',
        ],
    ],
];
