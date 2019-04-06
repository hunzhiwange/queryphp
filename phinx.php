<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidFileException;
use Dotenv\Exception\InvalidPathException;
use Leevel\Kernel\IApp;
use Leevel\Leevel\App;
use Symfony\Component\Console\Input\ArgvInput;

/**
 * ---------------------------------------------------------------
 * Composer
 * ---------------------------------------------------------------.
 *
 * 用于管理 PHP 依赖包
 */
require_once __DIR__.'/vendor/autoload.php';

/**
 * ---------------------------------------------------------------
 * 创建应用
 * ---------------------------------------------------------------.
 *
 * 注册应用基础服务
 */
$app = App::singletons(__DIR__);

/*
 * ---------------------------------------------------------------
 * 载入环境
 * ---------------------------------------------------------------.
 *
 * 读取 phinx 运行环境
 */
if (($input = new ArgvInput())->hasParameterOption('-e')) {
    putenv('RUNTIME_ENVIRONMENT='.$input->getParameterOption('-e'));
}

/**
 * 载入配置.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2018.12.03
 *
 * @version 1.0
 */
class PhinxLoad
{
    /**
     * 执行入口.
     *
     * @param \Leevel\Kernel\IApp $app
     *
     * @return array
     */
    public function handle(IApp $app): array
    {
        $this->checkRuntimeEnv($app);

        return $this->loadEnvData($app);
    }

    /**
     * 载入环境变量数据.
     *
     * @param \Leevel\Kernel\IApp $app
     *
     * @return array
     */
    private function loadEnvData(IApp $app): array
    {
        $oldEnv = $_ENV;
        $_ENV = [];

        try {
            (new Dotenv($app->envPath(), $app->envFile()))->overload();
        } catch (InvalidPathException $e) {
            throw new RuntimeException($e->getMessage());
        } catch (InvalidFileException $e) {
            throw new RuntimeException($e->getMessage());
        }

        $result = $_ENV;
        $_ENV = array_merge($oldEnv, $_ENV);

        return $result;
    }

    /**
     * 载入运行时环境变量.
     *
     * @param \Leevel\Kernel\IApp $appy
     */
    private function checkRuntimeEnv(IApp $app)
    {
        if (!getenv('RUNTIME_ENVIRONMENT')) {
            return;
        }

        $file = '.'.getenv('RUNTIME_ENVIRONMENT');

        // 校验运行时环境，防止测试用例清空非测试库的业务数据
        if (!is_file($fullFile = $app->envPath().'/'.$file)) {
            throw new RuntimeException(sprintf('Env file `%s` was not found.', $fullFile));
        }

        $app->setEnvFile($file);
    }
}

/*
 * ---------------------------------------------------------------
 * 读取配置
 * ---------------------------------------------------------------.
 *
 * 读取配置并且返回配置值
 */
(new PhinxLoad())->handle($app);

return [
    'paths' => [
        'migrations'    => 'database/migrations',
        'seeds'         => 'database/seeds',
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
        'testing'   => [
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
