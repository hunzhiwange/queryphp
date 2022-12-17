<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use App\Exceptions\BusinessException;
use App\Exceptions\ErrorCode;
use Leevel\Support\Collection;
use Leevel\Support\TypedIntArray;
use Leevel\Database\Ddd\Select;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 批量修改状态.
 */
trait Status
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(StatusParams $params): array
    {
        $params->validate();
        $this->save($this->findAll($params->ids), $params->status);

        return [];
    }

    /**
     * 保存状态
     */
    private function save(Collection $entitys, int $status): void
    {
        foreach ($entitys as $entity) {
            $entity->status = $status;
            $this->w->persist($entity);
        }

        $this->w->flush();
    }

    /**
     * 查询符合条件的数据.
     *
     * @throws \App\Exceptions\BusinessException
     */
    private function findAll(TypedIntArray $ids): Collection
    {
        /** @var \Leevel\Support\Collection $entitys */
        $entitys = $this->w
            ->repository($this->entity())
            ->findAll(function (Select $select) use ($ids) {
                $select->whereIn('id', $ids->toArray());
            });

        if (0 === count($entitys)) {
            throw new BusinessException(ErrorCode::BATCH_MODIFICATION_STATUS_NO_DATA_FOUND);
        }

        return $entitys;
    }
}
