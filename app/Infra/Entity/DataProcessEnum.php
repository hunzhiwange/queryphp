<?php

declare(strict_types=1);

namespace App\Infra\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

enum DataProcessEnum: int
{
    use Enum;

    #[Msg('待处理')]
    case PENDING = 0;

    #[Msg('处理成功')]
    case SUCCESS = 1;

    #[Msg('处理失败')]
    case FAIL = 2;
}
