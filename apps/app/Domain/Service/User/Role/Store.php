<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Domain\Service\Support\Store as CommonStore;

/**
 * 角色保存.
 */
class Store
{
    use CommonStore;

    protected string $entityClass = Role::class;
}
