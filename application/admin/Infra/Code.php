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

namespace Admin\Infra;

use Leevel\Cache\Proxy\Cache;

/**
 * 验证码存储.
 */
class Code
{
    /**
     * 设置验证码
     */
    public function set(string $id, string $code): void
    {
        Cache::set('code_'.$id, $code);
    }

    /**
     * 获取验证码
     */
    public function get(string $id): string
    {
        return Cache::get('code_'.$id) ?: '';
    }
}
