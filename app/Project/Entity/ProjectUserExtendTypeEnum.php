<?php

declare(strict_types=1);

namespace App\Project\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 项目用户扩展类型枚举.
 */
enum ProjectUserExtendTypeEnum: int
{
    use Enum;

    #[Msg('成员')]
    case MEMBER = 1;

    #[Msg('管理')]
    case ADMINISTRATOR = 2;
}
