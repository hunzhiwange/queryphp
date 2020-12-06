<?php

declare(strict_types=1);

namespace Common\Domain\Service\User\Role;

use Common\Domain\Entity\User\Role;
use Common\Domain\Service\Support\Status as CommonStatus;

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
