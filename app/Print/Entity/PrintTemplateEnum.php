<?php

declare(strict_types=1);

namespace App\Print\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

enum PrintTemplateEnum: int
{
    use Enum;

    #[Msg('默认模板')]
    case DEFAULT = 0;

    #[Msg('订单模板')]
    case ORDERS = 1;
}
