<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * 配置业务操作异常.
 */
class OptionBusinessException extends BusinessException
{
    /**
     * {@inheritDoc}
     */
    protected function getErrorMessage(int|object $code): string
    {
        return OptionErrorCode::description($code);
    }
}
