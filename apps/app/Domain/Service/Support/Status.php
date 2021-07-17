<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use App\Domain\Entity\Base\Common;
use App\Exceptions\BusinessException;
use App\Exceptions\ErrorCode;
use Leevel\Collection\Collection;
use Leevel\Collection\TypedIntArray;
use Leevel\Database\Ddd\Select;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate;

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
        $this->validateArgs($params);
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
        /** @var \Leevel\Collection\Collection $entitys */
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

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\BusinessException
     */
    private function validateArgs(StatusParams $params): void
    {
        $validator = Validate::make(
            $params->toArray(),
            [
                'ids'  => 'required|is_array',
                'status' => [
                    ['in', Common::values('status')],
                ],
            ],
            [
                'ids' => 'ID',
                'status' => __('状态值'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new BusinessException(ErrorCode::BATCH_MODIFICATION_STATUS_INVALID_ARGUMENT, $e, true);
        }
    }
}
