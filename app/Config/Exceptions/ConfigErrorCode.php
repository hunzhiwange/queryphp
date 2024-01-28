<?php

declare(strict_types=1);

namespace App\Config\Exceptions;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 配置业务错误码.
 */
enum ConfigErrorCode: int
{
    use Enum;

    #[Msg('站点状态错误')]
    case SITE_STATUS_ERROR = 1000040000;
}
