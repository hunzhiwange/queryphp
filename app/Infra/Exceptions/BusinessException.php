<?php

declare(strict_types=1);

namespace App\Infra\Exceptions;

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
        \Throwable $previous = null,
        float $duration = 5,
    ) {
        [$code, $message] = $this->prepareCodeAndMessage($code, $message, $overrideMessage);
        parent::__construct($message, $code, $previous, $duration);
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

    /**
     * 记录异常到日志.
     */
    protected function reportToLog(): void
    {
        try {
            /** @var \Leevel\Log\ILog $log */
            $log = \App::make('log');
            $log->error($this->getMessage(), ['exception' => (string) $this]);
        } catch (Throwable) {
        }
    }
}
