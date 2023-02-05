<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Leevel\Support\Enum;

/**
 * 公共状态值枚举.
 */
enum StatusEnum: int
{
    use Enum;

    #[msg('禁用')]
    case DISABLE = 0;

    #[msg('启用')]
    case ENABLE = 1;
}
