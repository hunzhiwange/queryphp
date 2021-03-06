<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Leevel\Di\Container;
use Leevel\Kernel\App;
use Leevel\Kernel\IApp;
use Symfony\Component\Console\Input\ArgvInput;
use Leevel\Option\Env;

// 加载 Composer
require __DIR__.'/vendor/autoload.php';

// 创建应用
$container = Container::singletons();
$app = new App($container, realpath(__DIR__));

// 载入环境
$input = new ArgvInput();
if ($input->hasParameterOption('-e')) {
    $env = $input->getParameterOption('-e');
} elseif ($input->hasParameterOption('--environment')) {
    $env = $input->getParameterOption('--environment');
} else {
    $env = 'env';
}
putenv('RUNTIME_ENVIRONMENT='.$env);

/**
 * 载入配置.
 */
class PhinxLoad
{
    use Env;
    
    /**
     * 执行入口.
     */
    public function handle(IApp $app): array
    {
        $this->checkRuntimeEnv($app);

        return $this->loadEnvData($app);
    }

    /**
     * 载入环境变量数据.
     */
    private function loadEnvData(IApp $app): array
    {
        $dotenv = Dotenv::createMutable($app->envPath(), $app->envFile());
        $this->setEnvVars($envVars = $dotenv->load());

        return $envVars;
    }

    /**
     * 载入运行时环境变量.
     *
     * @throws \RuntimeException
     */
    private function checkRuntimeEnv(IApp $app)
    {
        if (!getenv('RUNTIME_ENVIRONMENT')) {
            return;
        }
        
        $file = '.'.getenv('RUNTIME_ENVIRONMENT');
        if (!is_file($fullFile = $app->envPath().'/'.$file)) {
            $e = sprintf('Env file `%s` was not found.', $fullFile);

            throw new RuntimeException($e);
        }

        $app->setEnvFile($file);
    }
}

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
