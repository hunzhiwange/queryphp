<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use App\Infra\Exceptions\BusinessException;
use App\Infra\Exceptions\ErrorCode;
use Leevel\Database\Ddd\Select;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Collection;
use Leevel\Support\VectorInt;

/**
 * 批量修改状态.
 */
trait Status
{
    public function __construct(private UnitOfWork $w)
    {
    }

    /**
     * @throws \Exception
     */
    public function handle(StatusParams $params): array
    {
        $params->validate();
        $this->save($this->findAll($params->ids, $params), $params->status);

        return [];
    }

    /**
     * 保存状态
     */
    private function save(Collection $entities, int $status): void
    {
        foreach ($entities as $entity) {
            $entity->status = $status;
            $this->w->persist($entity);
        }

        $this->w->flush();
    }

    /**
     * 查询符合条件的数据.
     *
     * @throws \App\Infra\Exceptions\BusinessException|\Exception
     */
    private function findAll(VectorInt $ids, StatusParams $params): Collection
    {
        /** @var \Leevel\Support\Collection $entities */
        $entities = $this->w
            ->repository($params->entityClass)
            ->findAll(function (Select $select) use ($ids, $params): void {
                $primaryId = $params->entityClass::ID;
                $select->whereIn($primaryId, $ids->toArray());
            })
        ;

        if (0 === \count($entities)) {
            throw new BusinessException(ErrorCode::BATCH_MODIFICATION_STATUS_NO_DATA_FOUND);
        }

        return $entities;
    }
}
