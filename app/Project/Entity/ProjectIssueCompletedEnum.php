<?php

declare(strict_types=1);

namespace App\Project\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 项目问题完成状态枚举.
 */
enum ProjectIssueCompletedEnum: int
{
    use Enum;

    #[Msg('未完成')]
    case FALSE = 1;

    #[Msg('已完成')]
    case TRUE = 2;
}
