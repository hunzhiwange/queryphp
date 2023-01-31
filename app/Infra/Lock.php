<?php

declare(strict_types=1);

namespace App\Infra;

use Leevel\Cache\Proxy\Cache;

/**
 * 锁屏存储.
 */
class Lock
{
    /**
     * 锁屏.
     */
    public function set(string $id): void
    {
        Cache::set('lock_'.$id, '1');
    }

    /**
     * 解锁
     */
    public function delete(string $id): void
    {
        Cache::delete('lock_'.$id);
    }

    /**
     * 是否锁定.
     */
    public function has(string $id): bool
    {
        return false !== Cache::get('lock_'.$id);
    }
}
