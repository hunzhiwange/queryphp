<?php

declare(strict_types=1);

namespace App\User\Service\Permission;

use App\User\Entity\Permission;
use App\User\Entity\PermissionResource as EntityPermissionResource;
use Leevel\Database\Ddd\Select;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Collection;
use Leevel\Support\VectorInt;

/**
 * 权限资源授权.
 */
class Resource
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(ResourceParams $params): array
    {
        $this->save($params);

        return [];
    }

    /**
     * 保存.
     */
    private function save(ResourceParams $params): Permission
    {
        $entity = $this->entity($params->id);
        $this->setPermissionResource($params->id, $params->resourceId);
        $this->w->flush();

        return $entity;
    }

    /**
     * 查找存在资源.
     */
    private function findResources(int $permissionId): Collection
    {
        return $this->w
            ->repository(EntityPermissionResource::class)
            ->findAll(function (Select $select) use ($permissionId): void {
                $select->where('permission_id', $permissionId);
            })
        ;
    }

    /**
     * 验证参数.
     */
    private function entity(int $id): Permission
    {
        return $this->find($id);
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Permission
    {
        return $this->w
            ->repository(Permission::class)
            ->findOrFail($id)
        ;
    }

    /**
     * 设置权限资源授权.
     */
    private function setPermissionResource(int $permissionId, VectorInt $resourceId): void
    {
        $resources = $this->findResources($permissionId);
        $existResourceId = array_column($resources->toArray(), 'resource_id');
        foreach ($resourceId as &$rid) {
            if (!\in_array($rid, $existResourceId, true)) {
                $this->w->create($this->entityPermissionResource($permissionId, $rid));
            }
        }

        $resourceId = $resourceId->toArray();
        foreach ($resources as $r) {
            if (\in_array($r['resource_id'], $resourceId, true)) {
                continue;
            }
            $this->w->delete($r);
        }
    }

    /**
     * 创建授权实体.
     */
    private function entityPermissionResource(int $permissionId, int $resourceId): EntityPermissionResource
    {
        return new EntityPermissionResource([
            'permission_id' => $permissionId,
            'resource_id' => $resourceId,
        ]);
    }
}
