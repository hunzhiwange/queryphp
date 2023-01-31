<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Support\Dto;

/**
 * 用户权限数据参数.
 */
class PermissionParams extends Dto
{
    public int $id;

    public string $token;

    public int $refresh;
}
