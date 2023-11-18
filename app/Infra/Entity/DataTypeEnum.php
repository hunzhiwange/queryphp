<?php

declare(strict_types=1);

namespace App\Infra\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

enum DataTypeEnum: int
{
    use Enum;

    #[Msg('热数据')]
    case HOT = 0;

    #[Msg('温数据')]
    case WARM = 1;

    #[Msg('冷数据')]
    case COLD = 2;
}
