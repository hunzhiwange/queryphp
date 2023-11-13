<?php

declare(strict_types=1);

namespace App\Project\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 项目问题类型状态值枚举.
 */
enum ProjectTypeStatusEnum: int
{
    use Enum;

    #[Msg('禁用')]
    case DISABLE = 0;

    #[Msg('启用')]
    case ENABLE = 1;
}
