<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Domain\Service\User;

use Common\Domain\Entity\Permission;
use Common\Domain\Entity\PermissionResource as EntityPermissionResource;
use Leevel\Collection\Collection;
use Leevel\Database\Ddd\IUnitOfWork;

/**
 * 权限资源授权.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.21
 *
 * @version 1.0
 */
class PermissionResource
{
    /**
     * 事务工作单元.
     *
     * @var \Leevel\Database\Ddd\IUnitOfWork
     */
    protected $w;

    /**
     * 构造函数.
     *
     * @param \Leevel\Database\Ddd\IUnitOfWork $w
     */
    public function __construct(IUnitOfWork $w)
    {
        $this->w = $w;
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
        $this->save($input);

        return [];
    }

    /**
     * 保存.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\Permission
     */
    protected function save(array $input): Permission
    {
        $entity = $this->entity($input);

        $this->setPermissionResource((int) $input['id'], $input['resource_id']);

        $this->w->flush();

        return $entity;
    }

    /**
     * 查找存在资源.
     *
     * @param int $permissionId
     *
     * @return Leevel\Collection\Collection
     */
    protected function findResources(int $permissionId): Collection
    {
        return $this->w->repository(EntityPermissionResource::class)->
        findAll(function ($select) use ($permissionId) {
            $select->where('permission_id', $permissionId);
        });
    }

    /**
     * 验证参数.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\Permission
     */
    protected function entity(array $input): Permission
    {
        return $this->find((int) $input['id']);
    }

    /**
     * 查找实体.
     *
     * @param int $id
     *
     * @return \Common\Domain\Entity\Permission
     */
    protected function find(int $id): Permission
    {
        return $this->w->repository(Permission::class)->findOrFail($id);
    }

    /**
     * 设置权限资源授权.
     *
     * @param int   $permissionId
     * @param array $resourceId
     */
    protected function setPermissionResource(int $permissionId, array $resourceId): void
    {
        $existResource = [];

        foreach ($resourceId as $rid) {
            $this->w->replace($this->entityPermissionResource($permissionId, (int) $rid));
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
     * @param int $permissionId
     * @param int $resourceId
     *
     * @return \Common\Domain\Entity\EntityPermissionResource
     */
    protected function entityPermissionResource(int $permissionId, int $resourceId): EntityPermissionResource
    {
        return new EntityPermissionResource([
            'permission_id' => $permissionId,
            'resource_id'   => $resourceId,
        ]);
    }
}
