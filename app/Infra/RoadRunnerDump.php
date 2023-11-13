<?php

declare(strict_types=1);

namespace App\Infra;

use Spiral\Debug;

/**
 * 调试 RoadRunner 变量.
 *
 * @codeCoverageIgnore
 */
class RoadRunnerDump
{
    /**
     * 调试 RoadRunner 变量.
     */
    public static function handle(mixed $var, mixed ...$moreVars): mixed
    {
        static $dumper;

        if (null === $dumper) {
            $dumper = new Debug\Dumper();
            $dumper->setRenderer(Debug\Dumper::ERROR_LOG, new Debug\Renderer\ConsoleRenderer());
        }

        $dumper->dump($var, Debug\Dumper::ERROR_LOG);
        foreach ($moreVars as $v) {
            $dumper->dump($v);
        }

        if (\func_num_args() > 1) {
            array_unshift($moreVars, $var);

            return $moreVars;
        }

        return $var;
    }
}
