<?php

declare(strict_types=1);

namespace Common\Infra\Helper;

/**
 * 带有时间的消息.
 */
function message_with_time(string $message, string $format = 'Y-m-d H:i:s'): string
{
    return sprintf('[%s]', date($format)).$message.PHP_EOL;
}

class message_with_time
{
}
