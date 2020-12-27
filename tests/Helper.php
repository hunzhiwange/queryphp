<?php

declare(strict_types=1);

namespace Tests;

use Symfony\Component\Process\PhpExecutableFinder;

/**
 * 助手方法.
 */
trait Helper
{
    /**
     * 创建日志目录.
     */
    protected function makeLogsDir(): array
    {
        $tmp = explode('\\', static::class);
        array_shift($tmp);
        $className = array_pop($tmp);
        $traceDir = dirname(__DIR__).'/storage/app/tests/'.implode('/', $tmp);

        if (!is_dir($traceDir)) {
            mkdir($traceDir, 0777, true);
        }

        return [$traceDir, $className];
    }

    /**
     * 执行数据填充.
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
     */
    protected function seedClear(string $test, bool $debug = false): void
    {
        putenv('RUNTIME_SEED_CLEAR=clear');
        $this->seedRun($test, $debug);
        putenv('RUNTIME_SEED_CLEAR');
    }
}
