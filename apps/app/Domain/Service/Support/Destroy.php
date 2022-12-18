<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

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

        $primaryId = $this->entityClass::ID;
        $this->remove($this->find($params->{$primaryId}));

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
            ->flush();
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
}
