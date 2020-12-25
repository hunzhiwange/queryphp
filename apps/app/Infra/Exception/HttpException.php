<?php

declare(strict_types=1);

namespace App\Infra\Exception;

use Leevel\Kernel\Exception\HttpException as BaseHttpException;

/**
 * HTTP 异常.
 */
class HttpException extends BaseHttpException
{
}
