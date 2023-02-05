<?php

declare(strict_types=1);

namespace App\Exceptions;

use Leevel\Support\Enum;

/**
 * 配置业务错误码.
 */
enum OptionErrorCode: int
{
    use Enum;

    #[msg('站点状态错误')]
    case SITE_STATUS_ERROR = 1000040000;
}
