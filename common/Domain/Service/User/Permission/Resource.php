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

namespace Common\Domain\Service\User\Permission;

use Common\Domain\Entity\User\Permission;
use Common\Domain\Entity\User\PermissionResource as EntityPermissionResource;
use Leevel\Collection\Collection;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 权限资源授权.
 */
class Resource
{
    private UnitOfWork $w;

    public function __construct(UnitOfWork $w)
    {
        $this->w = $w;
    }

    public function handle(array $input): array
    {
        if (!isset($input['resource_id'])) {
            $input['resource_id'] = [];
        }
        $this->save($input);

        return [];
    }

    /**
     * 保存.
     */
    private function save(array $input): Permission
    {
        $entity = $this->entity($input);
        $this->setPermissionResource((int) $input['id'], $input['resource_id']);
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
            ->findAll(function ($select) use ($permissionId) {
                $select->where('permission_id', $permissionId);
            });
    }

    /**
     * 验证参数.
     */
    private function entity(array $input): Permission
    {
        return $this->find((int) $input['id']);
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Permission
    {
        return $this->w->repository(Permission::class)->findOrFail($id);
    }

    /**
     * 设置权限资源授权.
     */
    private function setPermissionResource(int $permissionId, array $resourceId): void
    {
        $existResource = [];

        foreach ($resourceId as $rid) {
            $rid = (int) $rid;
            $this->w->replace($this->entityPermissionResource($permissionId, $rid));
            $existResource[] = $rid;
        }

        foreach ($this->findResources($permissionId) as $r) {
            if (\in_array($r['resource_id'], $existResource, true)) {
                continue;
            }

            $this->w->delete($r);
        }
    }

    /**
     * 创建授权实体.
     *
     * @return \Common\Domain\Entity\EntityPermissionResource
     */
    private function entityPermissionResource(int $permissionId, int $resourceId): EntityPermissionResource
    {
        return new EntityPermissionResource([
            'permission_id' => $permissionId,
            'resource_id'   => $resourceId,
        ]);
    }
}
