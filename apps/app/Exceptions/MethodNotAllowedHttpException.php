<?php

declare(strict_types=1);

namespace App\Exceptions;

use Leevel\Kernel\Exception\MethodNotAllowedHttpException as BaseMethodNotAllowedHttpException;

/**
 * 方法禁用.
 *
 * - 禁用请求中指定的方法: 405.
 */
class MethodNotAllowedHttpException extends BaseMethodNotAllowedHttpException
{
}
