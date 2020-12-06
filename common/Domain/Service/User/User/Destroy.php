<?php

declare(strict_types=1);

namespace Common\Domain\Service\User\User;

use Common\Domain\Entity\User\User;
use Common\Domain\Service\Support\Destroy as CommonDestroy;

/**
 * 用户删除.
 */
class Destroy
{
    use CommonDestroy;

    /**
     * 返回实体.
     */
    private function entity(): string
    {
        return User::class;
    }
}
