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

use Leevel\Option\Helper\option_set;

/**
 * 使用方法.
 *
 * ``` php
 * echo f('Common\\Infra\\Helper\\force_close_debug');
 * ```
 */
function force_close_debug(): void
{
    f(option_set::class, 'debug', false);
}

class force_close_debug
{
}
