<?php

declare(strict_types=1);

namespace Common\Domain\Service\User\Permission;

use Common\Domain\Entity\User\Permission;
use Common\Domain\Service\Support\Status as CommonStatus;

/**
 * 批量修改权限状态.
 */
class Status
{
    use CommonStatus;

    /**
     * 返回实体.
     */
    private function entity(): string
    {
        return Permission::class;
    }
}
