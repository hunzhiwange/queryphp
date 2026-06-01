<?php

declare(strict_types=1);

use App\Infra\Module\Phinx\PhinxLoad;
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
    $development = $input->getParameterOption('--database');
} else {
    $development = 'development';
}

if ($input->hasParameterOption('--database-index')) {
    $databaseIndex = (string) $input->getParameterOption('--database-index');
} else {
    $databaseIndex = '';
}

if (!in_array($development, [
    'production',
    'production_common',
    'development',
    'development_common',
], true)) {
    throw new Exception('Database must be one of `production,production_common,development,development_common`.');
}

// 读取配置
(new PhinxLoad())->handle($app);

$migrationPath = str_contains($development, '_common') ? 'common' : 'data';

return [
    'paths' => [
        'migrations' => "database/{$migrationPath}/migrations",
        'seeds' => "database/{$migrationPath}/seeds",
    ],
    'environments' => [
        'default_migration_table' => 'phinx_log',
        'default_environment' => $development,
        'production' => [
            'adapter' => 'mysql',
            'host' => \App::proxy()->env('DATABASE_HOST', 'localhost'),
            'name' => \App::proxy()->env('DATABASE_NAME', '').$databaseIndex,
            'user' => \App::proxy()->env('DATABASE_USER', 'root'),
            'pass' => \App::proxy()->env('DATABASE_PASSWORD', ''),
            'port' => \App::proxy()->env('DATABASE_PORT', 3306),
            'charset' => 'utf8',
        ],
        'production_common' => [
            'adapter' => 'mysql',
            'host' => \App::proxy()->env('DATABASE_COMMON_HOST', 'localhost'),
            'name' => \App::proxy()->env('DATABASE_COMMON_NAME', ''),
            'user' => \App::proxy()->env('DATABASE_COMMON_USER', 'root'),
            'pass' => \App::proxy()->env('DATABASE_COMMON_PASSWORD', ''),
            'port' => \App::proxy()->env('DATABASE_COMMON_PORT', 3306),
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => \App::proxy()->env('DATABASE_HOST', 'localhost'),
            'name' => \App::proxy()->env('DATABASE_NAME', '').$databaseIndex,
            'user' => \App::proxy()->env('DATABASE_USER', 'root'),
            'pass' => \App::proxy()->env('DATABASE_PASSWORD', ''),
            'port' => \App::proxy()->env('DATABASE_PORT', 3306),
            'charset' => 'utf8',
        ],
        'development_common' => [
            'adapter' => 'mysql',
            'host' => \App::proxy()->env('DATABASE_COMMON_HOST', 'localhost'),
            'name' => \App::proxy()->env('DATABASE_COMMON_NAME', ''),
            'user' => \App::proxy()->env('DATABASE_COMMON_USER', 'root'),
            'pass' => \App::proxy()->env('DATABASE_COMMON_PASSWORD', ''),
            'port' => \App::proxy()->env('DATABASE_COMMON_PORT', 3306),
            'charset' => 'utf8',
        ],
    ],
];
