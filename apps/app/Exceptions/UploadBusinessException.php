<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * 上传业务操作异常.
 */
class UploadBusinessException extends BusinessException
{
    /**
     * {@inheritDoc}
     */
    protected function getErrorMessage(object $code): string
    {
        return UploadErrorCode::description($code);
    }
}
