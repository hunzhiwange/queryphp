<?php

declare(strict_types=1);

namespace database\common\seeds;
trait SeedBase
{
    public function execute(string $sql, array $params = []): int
    {
        $sqlAll = array_filter(explode(';', $sql), fn($v) => '' !== trim($v));
        if (!$sqlAll) {
            return 0;
        }

        foreach ($sqlAll as $item) {
            \Leevel\Database\Proxy\Db::connect('common')->execute($item, $params);
        }

        return 0;
    }
}
