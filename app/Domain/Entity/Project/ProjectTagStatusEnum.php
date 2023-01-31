<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Support\Enum;

/**
 * 项目标签状态值枚举.
 */
enum ProjectTagStatusEnum:int
{
    use Enum;

    #[msg('禁用')]
    case DISABLE = 0;

    #[msg('启用')]
    case ENABLE = 1;
}
