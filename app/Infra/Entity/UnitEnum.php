<?php

declare(strict_types=1);

namespace App\Infra\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

enum UnitEnum: int
{
    use Enum;

    #[Msg('小单位')]
    case SMALL = 1;

    #[Msg('中单位')]
    case MEDIUM = 2;

    #[Msg('大单位')]
    case LARGE = 3;
}
