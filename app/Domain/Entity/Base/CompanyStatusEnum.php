<?php

declare(strict_types=1);

namespace App\Domain\Entity\Base;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 公司状态值枚举.
 */
enum CompanyStatusEnum: int
{
    use Enum;

    #[Msg('禁用')]
    case DISABLE = 0;

    #[Msg('启用')]
    case ENABLE = 1;
}
