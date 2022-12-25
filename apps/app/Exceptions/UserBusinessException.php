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
        return UserErrorCode::description($code);
    }
}
