<?php

declare(strict_types=1);

namespace Common\Infra\Exception;

use Leevel\Kernel\Exception\UnprocessableEntityHttpException as BaseUnprocessableEntityHttpException;

/**
 * 无法处理的实体.
 *
 * - 请求格式正确，但是由于含有语义错误，无法响应: 422.
 */
class UnprocessableEntityHttpException extends BaseUnprocessableEntityHttpException
{
}
