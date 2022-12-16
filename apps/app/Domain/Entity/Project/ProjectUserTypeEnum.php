<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Support\BaseEnum;

/**
 * 项目用户类型枚举.
 */
enum ProjectUserTypeEnum:int
{
    use BaseEnum;

    #[msg('成员')]
    case MEMBER = 1;

    #[msg('收藏')]
    case FAVOR = 2;

    #[msg('关注')]
    case FOLLOW = 3;
}
