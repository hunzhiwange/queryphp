<?php

declare(strict_types=1);

namespace App\Infra\Helper;

use Leevel\Database\Migrations\Migration;

class BatchDropTable
{
    public static function handle(Migration $migration, string $baseDropTableSql, int $maxIndex = 1): void
    {
        for ($index = 0; $index <= $maxIndex; ++$index) {
            $databaseDataIndex = $index ?: '';
            $migration->execute('DROP TABLE IF EXISTS `'.str_replace('[database_data_index]', (string) $databaseDataIndex, $baseDropTableSql).'`;');
        }
    }
}
