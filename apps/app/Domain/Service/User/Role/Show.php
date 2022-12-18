<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Service\Support\Show as CommonShow;
use App\Domain\Entity\User\Role;

/**
 * 角色查询.
 */
class Show
{
    use CommonShow;

    protected string $entityClass = Role::class;
}
