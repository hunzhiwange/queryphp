<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Support\BaseEnum;

/**
 * 项目模块状态值枚举.
 */
enum ProjectModuleStatusEnum:int
{
    use BaseEnum;

    #[msg('禁用')]
    case DISABLE = 0;

    #[msg('启用')]
    case ENABLE = 1;
}
