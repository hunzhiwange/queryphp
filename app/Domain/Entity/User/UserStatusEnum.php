<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

use Leevel\Support\Enum;

/**
 * 用户状态值枚举.
 */
enum UserStatusEnum: int
{
    use Enum;

    #[msg('禁用')]
    case DISABLE = 0;

    #[msg('启用')]
    case ENABLE = 1;
}
