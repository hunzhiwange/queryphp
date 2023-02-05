<?php

declare(strict_types=1);

namespace App\Exceptions;

trait PrepareCodeAndMessage
{
    /**
     * @throws \Exception
     */
    public function prepareCodeAndMessage(
        int|object $code = 0,
        string $message = '',
        bool $overrideMessage = false
    ) {
        $message = $overrideMessage ? $message :
                    $this->getErrorMessage($code).($message ? ': '.$message : '');
        if (\is_object($code)) {
            if (!enum_exists($codeEnumClass = $code::class)) {
                throw new \Exception(sprintf('Enum %s is not exists.', $codeEnumClass));
            }
            $code = $code->value;
        }

        return [$code, $message];
    }
}
