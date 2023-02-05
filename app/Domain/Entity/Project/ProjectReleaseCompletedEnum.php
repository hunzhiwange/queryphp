<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Support\Enum;

/**
 * 项目版本完成状态值枚举.
 */
enum ProjectReleaseCompletedEnum: int
{
    use Enum;

    #[msg('未开始')]
    case NOT_STARTED = 1;

    #[msg('进行中')]
    case ONGOING = 2;

    #[msg('延期发布')]
    case DELAYED_RELEASE = 3;

    #[msg('已发布')]
    case PUBLISHED = 4;
}
