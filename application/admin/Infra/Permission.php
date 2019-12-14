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
 * 权限存储.
 */
class Permission
{
    /**
     * 设置权限.
     *
     * @param string $permission
     */
    public function set(string $id, array $permission): void
    {
        Cache::set('permission_'.$id, $permission);
    }

    /**
     * 获取权限.
     *
     * @return string
     */
    public function get(string $id): array
    {
        return Cache::get('permission_'.$id) ?: ['static' => [], 'dynamic' => []];
    }
}
