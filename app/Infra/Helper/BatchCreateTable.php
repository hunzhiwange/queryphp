<?php

declare(strict_types=1);

namespace App\Infra\Helper;

use Leevel\Database\Migrations\Migration;

class BatchCreateTable
{
    public static function handle(Migration $migration, string $baseCreateTableSql, int $maxIndex = 2): void
    {
        for ($index = 0; $index <= $maxIndex; ++$index) {
            $databaseDataIndex = $index ?: '';
            $migration->execute(str_replace('[database_data_index]', (string) $databaseDataIndex, $baseCreateTableSql));
        }
    }
}
