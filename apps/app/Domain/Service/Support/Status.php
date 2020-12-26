<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use App\Exceptions\BusinessException;
use Leevel\Collection\Collection;
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

    public function handle(array $input): array
    {
        $this->validateArgs($input);
        $input['ids'] = array_map(function ($item) {
            return (int) $item;
        }, $input['ids']);
        $this->save($this->findAll($input), (int) $input['status']);

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
    private function findAll(array $input): Collection
    {
        /** @var \Leevel\Collection\Collection $entitys */
        $entitys = $this->w
            ->repository($this->entity())
            ->findAll(function ($select) use ($input) {
                $select->whereIn('id', $input['ids']);
            });

        if (0 === count($entitys)) {
            throw new BusinessException(__('未发现数据'));
        }

        return $entitys;
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\BusinessException
     */
    private function validateArgs(array $input): void
    {
        $validator = Validate::make(
            $input,
            [
                'ids'          => 'required|is_array',
            ],
            [
                'ids'          => 'ID',
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new BusinessException($e);
        }
    }
}
