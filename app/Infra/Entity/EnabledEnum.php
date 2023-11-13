<?php

declare(strict_types=1);

namespace App\Infra\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 启用禁用状态值枚举.
 */
enum EnabledEnum: int
{
    use Enum;

    #[Msg('启用')]
    case ENABLE = 1;

    #[Msg('禁用')]
    case DISABLE = 0;
}
