<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * 配置业务错误码.
 */
final class OptionErrorCode extends ErrorCode
{
    #[msg('站点状态错误')]
    public const SITE_STATUS_ERROR = 1000040000;
}
