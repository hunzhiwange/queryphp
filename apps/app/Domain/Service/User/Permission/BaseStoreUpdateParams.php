<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Validate\ValidateParams;

trait BaseStoreUpdateParams
{
    use ValidateParams;

    public string $num;

    public string $name;

    public int $status;

    public int $pid;
}
