<?php

declare(strict_types=1);

namespace App\Exceptions;

use Leevel\Support\BaseEnum;

/**
 * 配置业务错误码.
 */
enum OptionErrorCode:int
{
    use BaseEnum;

    #[msg('站点状态错误')]
    case SITE_STATUS_ERROR = 1000040000;
}
