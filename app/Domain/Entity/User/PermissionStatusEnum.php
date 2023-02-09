<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 权限状态值枚举.
 */
enum PermissionStatusEnum: int
{
    use Enum;

    #[Msg('禁用')]
    case DISABLE = 0;

    #[Msg('启用')]
    case ENABLE = 1;
}
