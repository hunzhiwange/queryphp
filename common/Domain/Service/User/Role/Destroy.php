<?php

declare(strict_types=1);

namespace Common\Domain\Service\User\Role;

use Common\Domain\Entity\User\Role;
use Common\Domain\Service\Support\Destroy as CommonDestroy;

/**
 * 角色删除.
 */
class Destroy
{
    use CommonDestroy;

    /**
     * 返回实体.
     */
    private function entity(): string
    {
        return Role::class;
    }
}
