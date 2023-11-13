<?php

declare(strict_types=1);

namespace App\Infra\Helper;

use Phinx\Migration\AbstractMigration;

class BatchDropTable
{
    public static function handle(AbstractMigration $migration, string $baseDropTableSql, int $maxIndex = 1): void
    {
        for ($index = 0; $index <= $maxIndex; ++$index) {
            $databaseDataIndex = $index ?: '';
            $migration->table(str_replace('[database_data_index]', (string) $databaseDataIndex, $baseDropTableSql))->drop()->save();
        }
    }
}
