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
    protected function getErrorMessage(object $code): string
    {
        // @phpstan-ignore-next-line
        return AuthErrorCode::description($code);
    }
}
