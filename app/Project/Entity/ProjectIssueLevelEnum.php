<?php

declare(strict_types=1);

namespace App\Project\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 项目问题优先级别枚举.
 */
enum ProjectIssueLevelEnum: int
{
    use Enum;

    #[Msg('极高')]
    case HIGHEST = 1;

    #[Msg('高')]
    case HIGH = 2;

    #[Msg('中')]
    case MEDIUM = 3;

    #[Msg('低')]
    case LOW = 4;

    #[Msg('极低')]
    case LOWEST = 5;
}
