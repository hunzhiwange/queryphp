<?php

declare(strict_types=1);

namespace App\Infra\Database;

use Leevel\Database\Condition;

class Demo
{
    public function handle(\Closure $next, Condition $condition, array $middlewaresConfigs): array
    {
        return $next($condition, $middlewaresConfigs);
    }

    public function terminate(\Closure $next, Condition $condition, array $middlewaresConfigs, array $makeSql): array
    {
        return $next($condition, $middlewaresConfigs, $makeSql);
    }
}
