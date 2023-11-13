<?php

declare(strict_types=1);

namespace App\User\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 用户状态值枚举.
 */
enum UserStatusEnum: int
{
    use Enum;

    #[Msg('待审')]
    case PENDING = 2;

    #[Msg('启用')]
    case ENABLE = 1;

    #[Msg('禁用')]
    case DISABLE = 0;
}
