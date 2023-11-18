<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

enum EntityPersistEnum: int
{
    use Enum;

    #[Msg('保存')]
    case STORE = 1;

    #[Msg('更新')]
    case UPDATE = 2;

    #[Msg('覆盖')]
    case REPLACE = 3;
}
