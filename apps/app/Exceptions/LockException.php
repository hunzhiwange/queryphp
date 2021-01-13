<?php

declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use Leevel\Kernel\Exceptions\HttpException;
use Symfony\Component\HttpFoundation\Response;

/**
 * 锁定异常.
 */
class LockException extends HttpException
{
    /**
     * 构造函数.
     */
    public function __construct(
        int $code = 0,
        string $message = '',
        bool $overrideMessage = false,
        Throwable $previous = null
    )
    {
        $message = $overrideMessage ? $message : 
                    $this->getErrorMessage($code).($message ? ': '.$message : '');
        parent::__construct(Response::HTTP_FAILED_DEPENDENCY, $message, $code, $previous);
    }

    /**
     * 获取错误消息.
     */
    protected function getErrorMessage(int $code): string
    {
        return AuthErrorCode::getErrorMessage($code);
    }
}
