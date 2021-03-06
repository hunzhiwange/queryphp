<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Domain\Service\Support\Status as CommonStatus;

/**
 * 批量修改角色状态.
 */
class Status
{
    use CommonStatus;

    /**
     * 返回实体.
     */
    private function entity(): string
    {
        return Role::class;
    }
}
