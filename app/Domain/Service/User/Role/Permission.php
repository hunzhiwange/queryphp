<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Domain\Entity\User\RolePermission as EntityRolePermission;
use Leevel\Database\Ddd\Select;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Collection;
use Leevel\Support\TypedIntArray;

/**
 * 角色授权.
 */
class Permission
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(PermissionParams $params): array
    {
        $this->save($params);

        return [];
    }

    /**
     * 保存.
     */
    private function save(PermissionParams $params): Role
    {
        $entity = $this->entity($params->id);
        $this->setRolePermission($params->id, $params->permissionId);
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
            ->findAll(function (Select $select) use ($roleId) {
                $select->where('role_id', $roleId);
            });
    }

    /**
     * 验证参数.
     */
    private function entity(int $roleId): Role
    {
        return $this->find($roleId);
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
    private function setRolePermission(int $roleId, TypedIntArray $permissionId): void
    {
        $permissions = $this->findPermissions($roleId);
        $existPermissionId = array_column($permissions->toArray(), 'permission_id');
        foreach ($permissionId as &$pid) {
            if (!\in_array($pid, $existPermissionId, true)) {
                $this->w->create($this->entityRolePermission($roleId, $pid));
            }
        }

        $permissionId = $permissionId->toArray();
        foreach ($permissions as $p) {
            if (\in_array($p['permission_id'], $permissionId, true)) {
                continue;
            }
            $this->w->delete($p);
        }
    }

    /**
     * 创建授权实体.
     */
    private function entityRolePermission(int $roleId, int $permissionId): EntityRolePermission
    {
        return new EntityRolePermission([
            'role_id'         => $roleId,
            'permission_id'   => $permissionId,
        ]);
    }
}
