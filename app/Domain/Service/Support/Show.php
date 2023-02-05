<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 通用查询.
 */
trait Show
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(ShowParams $params): array
    {
        $primaryId = $this->entityClass::ID;
        $entity = $this->find($params->{$primaryId});
        $result = $entity->toArray();
        $this->prepareData($entity, $result);

        return $result;
    }

    private function prepareData(Entity $entity, array &$result): void
    {
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Entity
    {
        return $this->w
            ->repository($this->entityClass)
            ->findOrFail($id)
        ;
    }
}
