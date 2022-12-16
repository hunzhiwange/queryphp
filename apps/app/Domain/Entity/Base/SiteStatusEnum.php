<?php

declare(strict_types=1);

namespace App\Domain\Entity\Base;

use Leevel\Support\BaseEnum;

/**
 * 站点状态值枚举.
 */
enum SiteStatusEnum:int
{
    use BaseEnum;

    #[msg('禁用')]
    case DISABLE = 0;

    #[msg('启用')]
    case ENABLE = 1;
}
