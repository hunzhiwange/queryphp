<?php

declare(strict_types=1);

namespace App\Exceptions;

use Leevel\Kernel\Exceptions\BusinessException as BaseBusinessException;
use Throwable;

/**
 * 通用业务操作异常.
 */
class BusinessException extends BaseBusinessException
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
     * 上报日志.
     */
    public function report(): void
    {
        $this->reportToLog();
    }

    /**
     * 异常是否需要上报.
     */
    public function reportable(): bool
    {
        return $this->getImportance() > self::DEFAULT_LEVEL;
    }

    public function render()
    {
        if (\App::isDebug()) {
            return false;
        }

        $jsonMessage = $this->jsonStringToArray($this->message);
        if (!\is_array($jsonMessage)) {
            return false;
        }

        return [
            'error' => [
                'type' => self::class,
                'message' => $this->message,
                'json' => $jsonMessage,
            ],
            'code' => $this->code,
        ];
    }

    protected function jsonStringToArray(string $value): mixed
    {
        try {
            return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * 获取错误消息.
     */
    protected function getErrorMessage(object $code): string
    {
        // @phpstan-ignore-next-line
        return ErrorCode::description($code);
    }

    /**
     * 记录异常到日志.
     */
    protected function reportToLog(): void
    {
        try {
            /** @var \Leevel\Log\ILog $log */
            $log = \App::make('log');
            $log->error($this->getMessage(), ['exception' => (string) $this]);
            $log->flush();
        } catch (Throwable) {
        }
    }
}
