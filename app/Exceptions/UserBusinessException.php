<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * 用户业务操作异常.
 */
class UserBusinessException extends BusinessException
{
    /**
     * {@inheritDoc}
     */
    protected function getErrorMessage(object $code): string
    {
        // @phpstan-ignore-next-line
        return UserErrorCode::description($code);
    }
}
