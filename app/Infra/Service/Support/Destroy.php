<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 删除数据.
 */
trait Destroy
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(DestroyParams $params): array
    {
        $params->validate();
        if (method_exists($this, 'validate')) {
            $this->validate($params);
        }

        $primaryId = $params->entityClass::ID;
        $entity = $this->find($params->{$primaryId}, $params);

        // 删除前置操作
        if (method_exists($entity, 'beforeDeleteEvent')) {
            $entity::event(Entity::BEFORE_DELETE_EVENT, fn () => $entity->beforeDeleteEvent());
        }

        $this->remove($entity);

        return [];
    }

    /**
     * 删除实体.
     */
    private function remove(Entity $entity): void
    {
        $this->w
            ->persist($entity)
            ->delete($entity)
            ->flush()
        ;
    }

    /**
     * 查找实体.
     */
    private function find(int $id, DestroyParams $params): Entity
    {
        return $this->w
            ->repository($params->entityClass)
            ->findOrFail($id)
        ;
    }
}
