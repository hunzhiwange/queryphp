<?php

declare(strict_types=1);

trait SeedBase
{
    public function execute(string $sql, array $params = []): int
    {
        $sqlAll = array_filter(explode(';', $sql), fn ($v) => '' !== trim($v));
        if (!$sqlAll) {
            return 0;
        }

        foreach ($sqlAll as $item) {
            \Leevel\Database\Proxy\Db::execute($item, $params);
        }

        return 0;
    }
}
