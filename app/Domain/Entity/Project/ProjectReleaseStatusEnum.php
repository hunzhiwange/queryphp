<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 项目版本状态值枚举.
 */
enum ProjectReleaseStatusEnum: int
{
    use Enum;

    #[Msg('禁用')]
    case DISABLE = 0;

    #[Msg('启用')]
    case ENABLE = 1;
}
