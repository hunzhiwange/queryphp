<?php

declare(strict_types=1);

namespace App\Infra\Helper;

/**
 * 带有时间的消息.
 */
class MessageWithTime
{
    public static function handle(string $message, string $format = 'Y-m-d H:i:s'): string
    {
        return sprintf('[%s]', date($format)) . $message . PHP_EOL;
    }
}
