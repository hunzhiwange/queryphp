<?php

declare(strict_types=1);

namespace Admin\Infra\Exception;

use Exception;
use Leevel\Kernel\Exceptions\HttpException;

/**
 * 锁定异常.
 */
class LockException extends HttpException
{
    /**
     * 构造函数.
     */
    public function __construct(?string $message = null, int $code = 0, ?Exception $previous = null)
    {
        parent::__construct(424, $message, $code, $previous);
    }
}
