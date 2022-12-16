<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * 认证业务操作异常.
 */
class AuthBusinessException extends BusinessException
{
    /**
     * {@inheritDoc}
     */
    protected function getErrorMessage(int|object $code): string
    {
        return AuthErrorCode::description($code);
    }
}
