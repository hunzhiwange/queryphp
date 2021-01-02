<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * 上传业务错误码.
 */
class UploadErrorCode extends ErrorCode
{
    #[msg('文件上传失败')]
    const FILE_UPLOAD_FAILED = 1000010000;
}
