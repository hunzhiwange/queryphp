<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * 上传业务错误码.
 */
final class UploadErrorCode extends ErrorCode
{
    #[msg('文件上传失败')]
    public const FILE_UPLOAD_FAILED = 1000010000;

    #[msg('文件上传保存失败')]
    public const FILE_UPLOAD_WRITE_FAILED = 1000010001;
}
