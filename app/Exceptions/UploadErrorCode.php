<?php

declare(strict_types=1);

namespace App\Exceptions;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 上传业务错误码.
 */
enum UploadErrorCode: int
{
    use Enum;

    #[Msg('文件上传失败')]
    case FILE_UPLOAD_FAILED = 1000020000;

    #[Msg('文件上传保存失败')]
    case FILE_UPLOAD_WRITE_FAILED = 1000020001;
}
