<?php

declare(strict_types=1);

namespace App\Infra;

use Leevel\Cache\Proxy\Cache;

/**
 * 权限缓存.
 */
class PermissionCache
{
    /**
     * 设置权限.
     */
    public function set(string $id, array $permission): void
    {
        Cache::set('permission:'.$id, $permission);
    }

    /**
     * 获取权限.
     */
    public function get(string $id): array
    {
        return Cache::get('permission:'.$id) ?: ['static' => [], 'dynamic' => []];
    }
}
