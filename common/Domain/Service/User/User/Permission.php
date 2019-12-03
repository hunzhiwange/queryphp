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

namespace Common\Domain\Service\User\User;

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
     * @var \Common\Domain\Service\User\User\UserPermission
     */
    protected $permission;

    /**
     * 构造函数.
     *
     * @param \Common\Domain\Service\User\User\UserPermission $permission
     */
    public function __construct(PermissionCache $permissionCache, UserPermission $permission)
    {
        $this->permissionCache = $permissionCache;
        $this->permission = $permission;
    }

    /**
     * 响应方法.
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
     */
    protected function getPermission(string $token, int $userId): array
    {
        $permission = $this->permission->handle(['user_id' => $userId]);
        $this->permissionCache->set($token, $permission);

        return $permission;
    }
}
