<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 公共状态值枚举.
 */
enum StatusEnum: int
{
    use Enum;

    #[Msg('禁用')]
    case DISABLE = 0;

    #[Msg('启用')]
    case ENABLE = 1;
}
