<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 通用保存.
 */
trait Store
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(StoreParams $params): array
    {
        $params->validate();
        $this->validate($params);

        return $this->save($params)->toArray();
    }

    private function validate(StoreParams $params): void
    {
    }

    /**
     * 保存.
     */
    private function save(StoreParams $params): Entity
    {
        $this->w
            ->persist($entity = $this->entity($params))
            ->flush()
        ;
        $entity->refresh();

        return $entity;
    }

    /**
     * 创建实体.
     */
    private function entity(StoreParams $params): Entity
    {
        return new $this->entityClass($this->data($params));
    }

    /**
     * 组装实体数据.
     */
    private function data(StoreParams $params): array
    {
        return $params->toArray();
    }
}
