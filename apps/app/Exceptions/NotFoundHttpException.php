<?php

declare(strict_types=1);

namespace App\Exceptions;

use Leevel\Kernel\Exception\NotFoundHttpException as BaseNotFoundHttpException;

/**
 * 未找到.
 *
 * - 用户发出的请求针对的是不存在的记录: 404.
 */
class NotFoundHttpException extends BaseNotFoundHttpException
{
}
