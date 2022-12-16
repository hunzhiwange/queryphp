<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

use Leevel\Support\Enum;

/**
 * 角色状态值枚举.
 */
enum RoleStatusEnum:int
{
    use Enum;

    #[msg('禁用')]
    case DISABLE = 0;

    #[msg('启用')]
    case ENABLE = 1;
}
