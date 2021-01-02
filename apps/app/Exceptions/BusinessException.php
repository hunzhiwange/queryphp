<?php

declare(strict_types=1);

namespace App\Exceptions;

use App;
use Leevel\Kernel\Exceptions\BusinessException as BaseBusinessException;
use Throwable;

abstract class BusinessException extends BaseBusinessException
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
                    $this->getErrorMessage($code).': '.$message;
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

    /**
     * 获取错误消息.
     */
    abstract protected function getErrorMessage(int $code): string;

    /**
     * 记录异常到日志.
     */
    protected function reportToLog(): void
    {
        try {
            /** @var \Leevel\Log\ILog $log */
            $log = App::make('log');
            $log->error($this->getMessage(), ['exception' => (string) $this]);
            $log->flush();
        } catch (Throwable) {
        }
    }
}
