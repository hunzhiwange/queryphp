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
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 角色授权.
 */
class Permission
{
    private UnitOfWork $w;

    public function __construct(UnitOfWork $w)
    {
        $this->w = $w;
    }

    public function handle(array $input): array
    {
        $this->save($input);

        return [];
    }

    /**
     * 保存.
     */
    private function save(array $input): Role
    {
        $entity = $this->entity($input);
        $this->setRolePermission((int) $input['id'], $input['permission_id'] ?? []);
        $this->w->flush();

        return $entity;
    }

    /**
     * 查找存在权限.
     */
    private function findPermissions(int $roleId): Collection
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
    private function entity(array $input): Role
    {
        return $this->find((int) $input['id']);
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Role
    {
        return $this->w->repository(Role::class)->findOrFail($id);
    }

    /**
     * 设置权限授权.
     */
    private function setRolePermission(int $roleId, array $permissionId): void
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
    private function entityRolePermission(int $roleId, int $permissionId): EntityRolePermission
    {
        return new EntityRolePermission([
            'role_id'         => $roleId,
            'permission_id'   => $permissionId,
        ]);
    }
}
