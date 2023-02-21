<?php

declare(strict_types=1);

namespace App\Database;

use Leevel\Database\Condition;

class Demo
{
    public function handle(\Closure $next, Condition $condition, array $middlewaresOptions): array
    {
        return $next($condition, $middlewaresOptions);
    }

    public function terminate(\Closure $next, Condition $condition, array $middlewaresOptions, array $makeSql): array
    {
        return $next($condition, $middlewaresOptions, $makeSql);
    }
}
