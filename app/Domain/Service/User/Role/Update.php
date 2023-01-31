<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Domain\Service\Support\Update as CommonUpdate;

/**
 * 角色更新.
 */
class Update
{
    use CommonUpdate;

    protected string $entityClass = Role::class;
}
