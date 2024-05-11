<?php

declare(strict_types=1);

namespace App\Project\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 项目版本完成状态值枚举.
 */
enum ProjectReleaseCompletedEnum: int
{
    use Enum;

    #[Msg('未开始')]
    case NOT_STARTED = 1;

    #[Msg('进行中')]
    case ONGOING = 2;

    #[Msg('延期发布')]
    case DELAYED_RELEASE = 3;

    #[Msg('已发布')]
    case PUBLISHED = 4;
}
