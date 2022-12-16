<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Support\BaseEnum;

/**
 * 项目用户数据类型枚举.
 */
enum ProjectUserDataTypeEnum:int
{
    use BaseEnum;

    #[msg('项目')]
    case PROJECT = 1;

    #[msg('问题')]
    case ISSUE = 2;
}
