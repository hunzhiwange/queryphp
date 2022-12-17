<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 角色更新.
 */
class Update
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(UpdateParams $params): array
    {
        $params->validate();

        return $this->save($params)->toArray();
    }

    /**
     * 验证参数.
     */
    private function entity(UpdateParams $params): Role
    {
        $entity = $this->find($params->id);
        $entity->withProps($this->data($params));

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Role
    {
        return $this->w
            ->repository(Role::class)
            ->findOrFail($id);
    }

    /**
     * 组装实体数据.
     */
    private function data(UpdateParams $params): array
    {
        return $params->except(['id'])->toArray();
    }

    /**
     * 保存.
     */
    private function save(UpdateParams $params): Role
    {
        $this->w
            ->persist($entity = $this->entity($params))
            ->flush();
        $entity->refresh();

        return $entity;
    }
}
