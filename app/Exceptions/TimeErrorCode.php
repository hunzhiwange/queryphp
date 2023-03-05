<?php

declare(strict_types=1);

namespace App\Exceptions;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 基于时间的错误码.
 */
enum TimeErrorCode: int
{
    use Enum;

    #[Msg('导入验证错误')]
    case ID20230305144912388 = 20230305144912388;
}
