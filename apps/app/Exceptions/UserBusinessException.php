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
    protected function getErrorMessage(int $code): string
    {
        return UserErrorCode::getErrorMessage($code);
    }
}
