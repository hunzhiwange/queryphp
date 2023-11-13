<?php

declare(strict_types=1);

namespace App\Infra\Exceptions;

trait PrepareCodeAndMessage
{
    /**
     * @throws \Exception
     */
    public function prepareCodeAndMessage(
        int|object $code = 0,
        string|array $message = '',
        bool $overrideMessage = false
    ): array {
        $baseMessage = !\is_int($code) ? $this->getErrorMessage($code) : '';
        if (\is_array($message)) {
            $message = json_encode($message, JSON_UNESCAPED_UNICODE);
        } elseif (!$overrideMessage) {
            $message = $baseMessage.($message ? ': '.$message : '');
        }

        if (\is_object($code)) {
            if (!enum_exists($codeEnumClass = $code::class)) {
                throw new \Exception(sprintf('Enum %s is not exists.', $codeEnumClass));
            }
            $code = $code->value;
        }

        return [$code, $message];
    }

    /**
     * 获取错误消息.
     */
    protected function getErrorMessage(object $code): string
    {
        // @phpstan-ignore-next-line
        return $code::description($code);
    }
}
