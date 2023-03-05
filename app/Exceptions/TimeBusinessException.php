<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * 基于时间的操作异常.
 */
class TimeBusinessException extends BusinessException
{
    /**
     * {@inheritDoc}
     */
    protected function getErrorMessage(object $code): string
    {
        // @phpstan-ignore-next-line
        return TimeErrorCode::description($code);
    }
}
