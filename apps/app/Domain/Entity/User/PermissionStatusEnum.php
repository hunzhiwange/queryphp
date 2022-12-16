<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

use Leevel\Support\BaseEnum;

/**
 * 权限状态值枚举.
 */
enum PermissionStatusEnum:int
{
    use BaseEnum;

    #[msg('禁用')]
    case DISABLE = 0;

    #[msg('启用')]
    case ENABLE = 1;
}
