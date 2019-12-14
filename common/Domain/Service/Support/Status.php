<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Domain\Service\Support;

use Common\Infra\Exception\BusinessException;
use Leevel\Collection\Collection;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Validate\Proxy\Validate;

/**
 * 批量修改状态.
 */
trait Status
{
    private IUnitOfWork $w;

    public function __construct(IUnitOfWork $w)
    {
        $this->w = $w;
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
     * @throws \Common\Infra\Exception\BusinessException
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
     * @throws \Common\Infra\Exception\BusinessException
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
            throw new BusinessException(json_encode($validator->error()));
        }
    }
}
