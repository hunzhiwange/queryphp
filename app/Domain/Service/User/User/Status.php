<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Domain\Service\Support\Status as CommonStatus;

/**
 * 批量修改用户状态.
 */
class Status
{
    use CommonStatus;

    protected string $entityClass = User::class;
}
