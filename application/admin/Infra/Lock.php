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
 * 锁屏存储.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2018.11.18
 *
 * @version 1.0
 */
class Lock
{
    /**
     * 锁屏.
     *
     * @param string $id
     */
    public function set(string $id): void
    {
        Cache::set('lock_'.$id, '1');
    }

    /**
     * 解锁
     *
     * @param string $id
     */
    public function delete(string $id): void
    {
        Cache::delete('lock_'.$id);
    }

    /**
     * 是否锁定.
     *
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return false !== Cache::get('lock_'.$id);
    }
}
