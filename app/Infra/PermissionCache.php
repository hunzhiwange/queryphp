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
        // JWT 生成的 token 很长，使用 md5 压缩一下
        Cache::set('permission:'.md5($id), $permission);
    }

    /**
     * 获取权限.
     *
     * @throws \RuntimeException
     */
    public function get(string $id): array|false
    {
        $id = md5($id);
        $permission = Cache::get('permission:'.$id);
        if (false === $permission) {
            return false;
        }

        if (!\is_array($permission)) {
            throw new \RuntimeException('Permission cache was invalid.');
        }

        if (!isset($permission['static']) || !\is_array($permission['static'])) {
            $permission['static'] = [];
        }

        if (!isset($permission['dynamic']) || !\is_array($permission['dynamic'])) {
            $permission['dynamic'] = [];
        }

        return $permission;
    }
}
