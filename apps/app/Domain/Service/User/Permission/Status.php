<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use App\Domain\Service\Support\Status as CommonStatus;

/**
 * 批量修改权限状态.
 */
class Status
{
    use CommonStatus;

    protected string $entityClass = Permission::class;
}
