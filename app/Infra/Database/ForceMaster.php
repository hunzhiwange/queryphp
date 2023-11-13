<?php

declare(strict_types=1);

namespace App\Infra\Database;

use Leevel\Database\Condition;

class ForceMaster
{
    public function terminate(\Closure $next, Condition $condition, array $middlewaresOptions, array $makeSql): array
    {
        $makeSql = array_merge(['force_master' => '/*FORCE_MASTER*/'], $makeSql);

        return $next($condition, $middlewaresOptions, $makeSql);
    }
}
