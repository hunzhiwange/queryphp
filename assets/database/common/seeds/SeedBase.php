<?php

declare(strict_types=1);

trait SeedBase
{
    /**
     * {@inheritDoc}
     */
    public function execute($sql): int
    {
        $sqlAll = array_filter(explode(';', $sql), fn ($v) => '' !== trim($v));
        if (!$sqlAll) {
            return 0;
        }

        foreach ($sqlAll as $item) {
            \Leevel\Database\Proxy\Db::connect('common')->execute($item);
        }

        return 0;
    }
}
