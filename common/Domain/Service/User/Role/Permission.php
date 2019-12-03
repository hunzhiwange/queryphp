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

namespace Common\Domain\Service\User\Role;

use Common\Domain\Entity\User\Role;
use Common\Domain\Entity\User\RolePermission as EntityRolePermission;
use Leevel\Collection\Collection;
use Leevel\Database\Ddd\IUnitOfWork;

/**
 * 角色授权.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.21
 *
 * @version 1.0
 */
class Permission
{
    /**
     * 事务工作单元.
     *
     * @var \Leevel\Database\Ddd\IUnitOfWork
     */
    protected $w;

    /**
     * 构造函数.
     */
    public function __construct(IUnitOfWork $w)
    {
        $this->w = $w;
    }

    /**
     * 响应方法.
     */
    public function handle(array $input): array
    {
        $this->save($input);

        return [];
    }

    /**
     * 保存.
     */
    protected function save(array $input): Role
    {
        $entity = $this->entity($input);
        $this->setRolePermission((int) $input['id'], $input['permission_id'] ?? []);
        $this->w->flush();

        return $entity;
    }

    /**
     * 查找存在权限.
     */
    protected function findPermissions(int $roleId): Collection
    {
        return $this->w
            ->repository(EntityRolePermission::class)
            ->findAll(function ($select) use ($roleId) {
                $select->where('role_id', $roleId);
            });
    }

    /**
     * 验证参数.
     */
    protected function entity(array $input): Role
    {
        return $this->find((int) $input['id']);
    }

    /**
     * 查找实体.
     */
    protected function find(int $id): Role
    {
        return $this->w->repository(Role::class)->findOrFail($id);
    }

    /**
     * 设置权限授权.
     */
    protected function setRolePermission(int $roleId, array $permissionId): void
    {
        $existPermission = [];
        foreach ($permissionId as $pid) {
            $pid = (int) $pid;
            $this->w->replace($this->entityRolePermission($roleId, $pid));
            $existPermission[] = $pid;
        }

        foreach ($this->findPermissions($roleId) as $p) {
            if (\in_array($p['permission_id'], $existPermission, true)) {
                continue;
            }

            $this->w->delete($p);
        }
    }

    /**
     * 创建授权实体.
     *
     * @return \Common\Domain\Entity\EntityRolePermission
     */
    protected function entityRolePermission(int $roleId, int $permissionId): EntityRolePermission
    {
        return new EntityRolePermission([
            'role_id'         => $roleId,
            'permission_id'   => $permissionId,
        ]);
    }
}
