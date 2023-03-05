<?php

declare(strict_types=1);

namespace App\Exceptions;

use Leevel\Kernel\Exceptions\UnauthorizedHttpException as BaseUnauthorizedHttpException;

class UnauthorizedHttpException extends BaseUnauthorizedHttpException
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
        parent::__construct($message, $code, $previous);
    }

    /**
     * 获取错误消息.
     */
    protected function getErrorMessage(object $code): string
    {
        // @phpstan-ignore-next-line
        return AuthErrorCode::description($code);
    }
}
