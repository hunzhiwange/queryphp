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
use Leevel\Database\Ddd\IEntity;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Validate\Proxy\Validate;

/**
 * 删除数据.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.09.04
 *
 * @version 1.0
 */
trait Destroy
{
    /**
     * 事务工作单元.
     *
     * @var \Leevel\Database\Ddd\IUnitOfWork
     */
    protected $w;

    /**
     * 构造函数.
     *
     * @param \Leevel\Database\Ddd\IUnitOfWork $w
     */
    public function __construct(IUnitOfWork $w)
    {
        $this->w = $w;
    }

    /**
     * 响应方法.
     *
     * @param array $input
     *
     * @return array
     */
    public function handle(array $input): array
    {
        $this->validateArgs($input);
        if (method_exists($this, 'validate')) {
            $this->validate($input);
        }
        $this->remove($this->find($input['id']));

        return [];
    }

    /**
     * 删除实体.
     *
     * @param \Leevel\Database\Ddd\IEntity $entity
     */
    private function remove(IEntity $entity)
    {
        $this->w
            ->persist($entity)
            ->remove($entity)
            ->flush();
    }

    /**
     * 查找实体.
     *
     * @param int $intId
     *
     * @return \Leevel\Database\Ddd\IEntity
     */
    private function find(int $id): IEntity
    {
        return $this->w->repository($this->entity())->findOrFail($id);
    }

    /**
     * 校验基本参数.
     *
     * @param array $input
     *
     * @throws \Common\Infra\Exception\BusinessException
     */
    private function validateArgs(array $input): void
    {
        $validator = Validate::make(
            $input,
            [
                'id'          => 'required',
            ],
            [
                'id'          => 'ID',
            ]
        );

        if ($validator->fail()) {
            throw new BusinessException(json_encode($validator->error()));
        }
    }
}
