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

namespace Common\Infra\Repository\User\User;

use Admin\Infra\Permission as PermissionCache;

/**
 * 用户权限数据.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.23
 *
 * @version 1.0
 */
class Permission
{
    /**
     * 权限缓存.
     *
     * @var \Admin\Infra\Permission
     */
    protected $permissionCache;

    /**
     * 获取用户权限.
     *
     * @var \Common\Infra\Repository\User\User\UserPermission
     */
    protected $permission;

    /**
     * 构造函数.
     *
     * @param \Admin\Infra\Permission                           $permissionCache
     * @param \Common\Infra\Repository\User\User\UserPermission $permission
     */
    public function __construct(PermissionCache $permissionCache, UserPermission $permission)
    {
        $this->permissionCache = $permissionCache;
        $this->permission = $permission;
    }

    /**
     * 响应方法.
     *
     * @param array $input
     *
     * @return array
     */
    public function handle(array $input): array
    {
        // 刷线缓存
        if ($input['refresh']) {
            return $this->getPermission($input['token'], (int) $input['id']);
        }

        return $this->permissionCache->get($input['token']);
    }

    /**
     * 获取权限.
     *
     * @param string $token
     * @param int    $userId
     *
     * @return array
     */
    protected function getPermission(string $token, int $userId): array
    {
        $permission = $this->permission->handle(['user_id' => $userId]);

        $this->permissionCache->set($token, $permission);

        return $permission;
    }
}
