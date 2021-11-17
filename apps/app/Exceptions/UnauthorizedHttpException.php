<?php

declare(strict_types=1);

namespace App\Exceptions;

use Leevel\Kernel\Exceptions\UnauthorizedHttpException as BaseUnauthorizedHttpException;
use Throwable;

class UnauthorizedHttpException extends BaseUnauthorizedHttpException
{
    /**
     * 构造函数.
     */
    public function __construct(
        int $code = 0,
        string $message = '',
        bool $overrideMessage = false,
        Throwable $previous = null
    ) {
        $message = $overrideMessage ? $message :
                    $this->getErrorMessage($code).($message ? ': '.$message : '');
        parent::__construct($message, $code, $previous);
    }

    /**
     * 获取错误消息.
     */
    protected function getErrorMessage(int $code): string
    {
        return AuthErrorCode::getErrorMessage($code);
    }
}
