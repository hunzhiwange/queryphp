<?php

declare(strict_types=1);

use App\Infra\Module\Migrations\Migration;
use Leevel\Database\Migrations\Config;
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

// 选择环境
if ($input->hasParameterOption('--environment')) {
    $environment = $input->getParameterOption('--environment');
} else {
    $environment = Config::ENVIRONMENT_DEFAULT;
}

if (!in_array($environment, [Config::ENVIRONMENT_DEFAULT, 'data', 'common'], true)) {
    throw new Exception(sprintf('Environment must be one of `%s,data,common`.', Config::ENVIRONMENT_DEFAULT));
}

// 读取迁移配置
(new Migration())->handle($app);

$migrationPath = 'common' === $environment ? 'common' : 'data';

return [
    'migrations_path' => "database/{$migrationPath}/migrations",
    'seeds_path' => "database/{$migrationPath}/seeds",
    'environment_default' => Config::ENVIRONMENT_DEFAULT,
    'environments' => [
        Config::ENVIRONMENT_DEFAULT => 'mysql',
        'data' => 'data',
        'common' => 'common',
    ],
];
