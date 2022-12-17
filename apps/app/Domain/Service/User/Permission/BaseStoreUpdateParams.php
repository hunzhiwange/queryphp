<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

trait BaseStoreUpdateParams
{
    public string $num;

    public string $name;

    public int $status;

    public int $pid;
}
