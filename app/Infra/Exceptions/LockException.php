<?php

declare(strict_types=1);

namespace App\Infra\Exceptions;

use Leevel\Kernel\Exceptions\HttpException;
use Symfony\Component\HttpFoundation\Response;

/**
 * 锁定异常.
 */
class LockException extends HttpException
{
    use PrepareCodeAndMessage;

    /**
     * 构造函数.
     *
     * @throws \Exception
     */
    public function __construct(
        int|object $code = 0,
        string|array $message = '',
        bool $overrideMessage = false,
        \Throwable $previous = null
    ) {
        [$code, $message] = $this->prepareCodeAndMessage($code, $message, $overrideMessage);
        parent::__construct(Response::HTTP_FAILED_DEPENDENCY, $message, $code, $previous);
    }
}
