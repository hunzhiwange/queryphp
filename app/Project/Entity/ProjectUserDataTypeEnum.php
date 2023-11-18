<?php

declare(strict_types=1);

namespace App\Project\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 项目用户数据类型枚举.
 */
enum ProjectUserDataTypeEnum: int
{
    use Enum;

    #[Msg('项目')]
    case PROJECT = 1;

    #[Msg('问题')]
    case ISSUE = 2;
}
