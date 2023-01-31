<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Support\Dto;

/**
 * 用户权限查询参数.
 */
class UserPermissionParams extends Dto
{
    public int $userId;
}
