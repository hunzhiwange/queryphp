<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
