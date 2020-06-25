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

use Leevel\Option\Proxy\Option;

/**
 * 强制关闭调试模式.
 */
function force_close_debug(): void
{
    Option::set('debug', false);
}

class force_close_debug
{
}
