<?php

declare(strict_types=1);

namespace App\Infra\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 是否态值枚举.
 */
enum YesEnum: int
{
    use Enum;

    #[Msg('是')]
    case YES = 1;

    #[Msg('否')]
    case NO = 0;
}
