<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Domain\Service\Support\Destroy as CommonDestroy;

/**
 * 角色删除.
 */
class Destroy
{
    use CommonDestroy;

    protected string $entityClass = Role::class;
}
