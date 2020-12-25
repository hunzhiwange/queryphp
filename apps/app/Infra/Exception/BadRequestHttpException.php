<?php

declare(strict_types=1);

namespace App\Infra\Exception;

use Leevel\Kernel\Exception\BadRequestHttpException as BaseBadRequestHttpException;

/**
 * 错误请求.
 *
 * - 服务器不理解请求的语法: 400.
 */
class BadRequestHttpException extends BaseBadRequestHttpException
{
}
