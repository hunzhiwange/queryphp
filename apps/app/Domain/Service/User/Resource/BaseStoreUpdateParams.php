<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

trait BaseStoreUpdateParams
{
    public string $num;

    public string $name;

    public int $status;
}
