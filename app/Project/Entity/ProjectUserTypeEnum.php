<?php

declare(strict_types=1);

namespace App\Project\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 项目用户类型枚举.
 */
enum ProjectUserTypeEnum: int
{
    use Enum;

    #[Msg('成员')]
    case MEMBER = 1;

    #[Msg('收藏')]
    case FAVOR = 2;

    #[Msg('关注')]
    case FOLLOW = 3;
}
