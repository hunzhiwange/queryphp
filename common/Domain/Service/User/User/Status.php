<?php

declare(strict_types=1);

namespace Common\Domain\Service\User\User;

use Common\Domain\Entity\User\User;
use Common\Domain\Service\Support\Status as CommonStatus;

/**
 * 批量修改用户状态.
 */
class Status
{
    use CommonStatus;

    /**
     * 返回实体.
     */
    private function entity(): string
    {
        return User::class;
    }
}
