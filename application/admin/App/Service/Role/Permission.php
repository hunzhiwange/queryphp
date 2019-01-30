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

namespace Admin\App\Service\Role;

use Common\Domain\Service\User\RolePermission;

/**
 * 角色授权.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class Permission
{
    /**
     * 权限资源授权服务.
     *
     * @var \Common\Domain\Service\User\RolePermission
     */
    protected $rolePermission;

    /**
     * 构造函数.
     *
     * @param \Common\Domain\Service\User\RolePermission $rolePermission
     */
    public function __construct(RolePermission $rolePermission)
    {
        $this->rolePermission = $rolePermission;
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
        return $this->rolePermission->handle($input);
    }
}
