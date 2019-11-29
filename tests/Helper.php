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

namespace Tests;

use Symfony\Component\Process\PhpExecutableFinder;

/**
 * 助手方法.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2018.08.26
 *
 * @version 1.0
 */
trait Helper
{
    /**
     * 创建日志目录.
     *
     * @var array
     */
    protected function makeLogsDir(): array
    {
        $tmp = explode('\\', static::class);
        array_shift($tmp);
        $className = array_pop($tmp);
        $traceDir = dirname(__DIR__).'/runtime/tests/'.implode('/', $tmp);

        if (!is_dir($traceDir)) {
            mkdir($traceDir, 0777, true);
        }

        return [$traceDir, $className];
    }

    /**
     * 执行数据填充.
     *
     * @param string $test
     * @param bool   $debug
     */
    protected function seedRun(string $test, bool $debug = false): void
    {
        $test = str_replace('\\', '', $test);

        // 判断是否存在
        $file = dirname(__DIR__).'/database/seeds/'.$test.'.php';

        if (!is_file($file)) {
            // 创建 seed
            $createCommand = sprintf(
                '%s artisan migrate:seedcreate %s'.(true === $debug ? ' -vvv' : ''),
                escapeshellarg((new PhpExecutableFinder())->find(false) ?: ''),
                $test
            );

            $result = exec($createCommand);

            if (true === $debug) {
                dump($createCommand);
                dump($result);
            }
        }

        // 执行 seed
        $seedCommand = sprintf(
            '%s artisan migrate:seedrun -s %s'.(true === $debug ? ' -vvv' : ''),
            escapeshellarg((new PhpExecutableFinder())->find(false) ?: ''),
            $test
        );

        $result = exec($seedCommand);

        if (true === $debug) {
            dump($seedCommand);
            dump($result);
        }
    }

    /**
     * 执行数据填充清理.
     *
     * @param string $test
     * @param bool   $debug
     */
    protected function seedClear(string $test, bool $debug = false): void
    {
        putenv('RUNTIME_SEED_CLEAR=clear');
        $this->seedRun($test, $debug);
        putenv('RUNTIME_SEED_CLEAR');
    }
}
