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
    protected function getErrorMessage(object $code): string
    {
        // @phpstan-ignore-next-line
        return ProjectErrorCode::description($code);
    }
}
