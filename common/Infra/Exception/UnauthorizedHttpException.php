<?php

declare(strict_types=1);

namespace Common\Infra\Exception;

use Leevel\Kernel\Exception\UnauthorizedHttpException as BaseUnauthorizedHttpException;

/**
 * 未授权.
 *
 * - 对于需要登录的网页，服务器可能返回此响应: 401.
 */
class UnauthorizedHttpException extends BaseUnauthorizedHttpException
{
}
