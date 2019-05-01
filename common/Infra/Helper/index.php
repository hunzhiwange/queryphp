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
 * 使用方法.
 *
 * ``` php
 * echo fn('Common\\Infra\\Helper\\foo_bar');
 * ```
 *
 * @param string $extend
 *
 * @return string
 */
function foo_bar(string $extend = ''): string
{
    return 'call foo bar'.$extend;
}

class index
{
}
