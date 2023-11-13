<?php

declare(strict_types=1);

namespace App\Company\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 应用状态值枚举.
 */
enum AppStatusEnum: int
{
    use Enum;

    #[Msg('启用')]
    case ENABLE = 1;

    #[Msg('禁用')]
    case DISABLE = 0;
}
