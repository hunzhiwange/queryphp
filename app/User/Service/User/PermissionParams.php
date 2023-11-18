<?php

declare(strict_types=1);

namespace App\User\Service\User;

use Leevel\Support\Dto;

/**
 * 用户权限数据参数.
 */
class PermissionParams extends Dto
{
    public int $id = 0;

    public string $token = '';

    public int $refresh = 0;
}
