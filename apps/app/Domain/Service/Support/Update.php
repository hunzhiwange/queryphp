<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 通用更新.
 */
 trait Update
{
    public function __construct(private UnitOfWork $w)
    {
    }

     public function beforeHandle(UpdateParams $params): void
     {
     }

    public function handle(UpdateParams $params): array
    {
        $this->beforeHandle($params);

        $params->validate();
        $this->validate($params);

        return $this->save($params)->toArray();
    }

     private function validate(UpdateParams $params): void
     {
     }

    /**
     * 验证参数.
     */
    private function entity(UpdateParams $params): Entity
    {
        $primaryId = $this->entityClass::ID;
        $entity = $this->find($params->{$primaryId});
        $entity->withProps($this->data($params));

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Entity
    {
        return $this->w
            ->repository($this->entityClass)
            ->findOrFail($id);
    }

    /**
     * 组装实体数据.
     */
    private function data(UpdateParams $params): array
    {
        $primaryId = $this->entityClass::ID;

        return $params->except([$primaryId])->toArray();
    }

    /**
     * 保存.
     */
    private function save(UpdateParams $params): Entity
    {
        $this->w
            ->persist($entity = $this->entity($params))
            ->flush();
        $entity->refresh();

        return $entity;
    }
}
