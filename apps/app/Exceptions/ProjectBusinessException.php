<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * 项目业务操作异常.
 */
class ProjectBusinessException extends BusinessException
{
    /**
     * {@inheritDoc}
     */
    protected function getErrorMessage(int $code): string
    {
        return ProjectErrorCode::getErrorMessage($code);
    }
}
