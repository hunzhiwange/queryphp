<?php

declare(strict_types=1);

namespace App\Infra\Exception;

use Leevel\Kernel\Exception\TooManyRequestsHttpException as BaseTooManyRequestsHttpException;

/**
 * 请求过于频繁异常.
 *
 * - 用户在给定的时间内发送了太多的请求: 429.
 */
class TooManyRequestsHttpException extends BaseTooManyRequestsHttpException
{
}
