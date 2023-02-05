<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Support\Enum;

/**
 * 项目用户扩展类型枚举.
 */
enum ProjectUserExtendTypeEnum: int
{
    use Enum;

    #[msg('成员')]
    case MEMBER = 1;

    #[msg('管理')]
    case ADMINISTRATOR = 2;
}
