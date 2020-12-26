<?php

declare(strict_types=1);

namespace App\Exceptions;

use Leevel\Kernel\Exception\InternalServerErrorHttpException as BaseInternalServerErrorHttpException;

/**
 * 服务器内部错误.
 *
 * - 服务器遇到错误，无法完成请求: 500.
 */
class InternalServerErrorHttpException extends BaseInternalServerErrorHttpException
{
}
