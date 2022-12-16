<?php

declare(strict_types=1);

namespace App\Domain\Entity\Base;

use Leevel\Support\Enum;

/**
 * 应用状态值枚举.
 */
enum AppStatusEnum:int
{
    use Enum;

    #[msg('禁用')]
    case DISABLE = 0;

    #[msg('启用')]
    case ENABLE = 1;
}
