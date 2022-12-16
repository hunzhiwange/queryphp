<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Support\Enum;

/**
 * 项目问题优先级别枚举.
 */
enum ProjectIssueLevelEnum:int
{
    use Enum;

    #[msg('极高')]
    case HIGHEST = 1;

    #[msg('高')]
    case HIGH = 2;

    #[msg('中')]
    case MEDIUM = 3;

    #[msg('低')]
    case LOW = 4;

    #[msg('极低')]
    case LOWEST = 5;
}
