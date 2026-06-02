<?php

declare(strict_types=1);

namespace App\Infra\Module\Migrations;

use Dotenv\Dotenv;
use Leevel\Config\Env;
use Leevel\Kernel\IApp;

/**
 * 载入迁移配置.
 */
class Migration
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
    private function checkRuntimeEnv(IApp $app): void
    {
        if (!getenv('RUNTIME_ENVIRONMENT')) {
            return;
        }

        $file = '.'.getenv('RUNTIME_ENVIRONMENT');
        if (!is_file($fullFile = $app->envPath().'/'.$file)) {
            throw new \RuntimeException(\sprintf('Env file `%s` was not found.', $fullFile));
        }

        $app->setEnvFile($file);
    }
}
