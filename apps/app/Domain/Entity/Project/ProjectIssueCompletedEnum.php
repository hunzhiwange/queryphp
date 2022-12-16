<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Support\BaseEnum;

/**
 * 项目问题完成状态枚举.
 */
enum ProjectIssueCompletedEnum:int
{
    use BaseEnum;

    #[msg('未完成')]
    case FALSE = 1;

    #[msg('已完成')]
    case TRUE = 2;
}
