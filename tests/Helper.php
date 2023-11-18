<?php

declare(strict_types=1);

namespace Tests;

use Codedungeon\PHPCliColors\Color;
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
        $traceDir = \dirname(__DIR__).'/storage/app/tests/'.implode('/', $tmp);

        if (!is_dir($traceDir)) {
            mkdir($traceDir, 0o777, true);
        }

        return [$traceDir, $className];
    }

    /**
     * 执行数据填充.
     */
    protected function seedRun(string $seed, bool $commonDatabase = false, bool $debug = false): void
    {
        $seed = str_replace('\\', '', $seed);
        $command = $debug ? ' -vvv' : '';
        if ($commonDatabase) {
            $command .= ' --database=development_common';
        }

        $migrationPath = $commonDatabase ? 'common' : 'data';

        $file = \dirname(__DIR__)."/assets/database/{$migrationPath}/seeds/".$seed.'.php';
        if (!is_file($file)) {
            // 创建 seed
            $createCommand = sprintf(
                '%s leevel migrate:seedcreate %s --env=env.phpunit'.$command,
                escapeshellarg((new PhpExecutableFinder())->find(false) ?: ''),
                $seed
            );

            $result = exec($createCommand);

            if ($debug) {
                echo Color::LIGHT_WHITE, $createCommand, Color::LIGHT_WHITE, PHP_EOL;
                echo Color::GREEN, $result, Color::RESET, PHP_EOL;
            }
        }

        // 执行 seed
        include_once \dirname(__DIR__)."/assets/database/{$migrationPath}/seeds/SeedBase.php";

        include_once $file;
        if (!class_exists($seed)) {
            throw new \Exception(sprintf('Seed %s was not found.', $seed));
        }
        $seedObject = new $seed();
        if ($commonDatabase) {
            $seedObject->commonDatabase = true;
        }
        if (!\is_callable([$seedObject, 'run'])) {
            throw new \Exception(sprintf('Seed \%s->run() was not found.', $seed));
        }
        $seedObject->run();

        if ($debug) {
            echo Color::LIGHT_WHITE, sprintf('%s->%s()', $seed, 'run'), Color::LIGHT_WHITE, PHP_EOL;
            echo Color::GREEN, 'Success', Color::RESET, PHP_EOL;
        }
    }

    /**
     * 执行数据填充清理.
     */
    protected function seedClear(string $test, bool $commonDatabase = false, bool $debug = false): void
    {
        putenv('RUNTIME_SEED_CLEAR=clear');

        if ($debug) {
            echo Color::RED, 'Seed clear start', Color::RED, PHP_EOL;
        }

        $this->seedRun($test, $commonDatabase, $debug);

        if ($debug) {
            echo Color::RED, 'Seed clear end', Color::RED, PHP_EOL;
        }

        putenv('RUNTIME_SEED_CLEAR');
    }
}
