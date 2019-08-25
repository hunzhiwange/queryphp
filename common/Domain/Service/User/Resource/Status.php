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

namespace Common\Domain\Service\User\Resource;

use Common\Domain\Entity\User\Resource;
use Common\Infra\Exception\BusinessException;
use Leevel\Collection\Collection;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Validate\Proxy\Validate;

/**
 * 批量修改资源状态.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class Status
{
    /**
     * 事务工作单元.
     *
     * @var \Leevel\Database\Ddd\IUnitOfWork
     */
    protected $w;

    /**
     * 输入数据.
     *
     * @var array
     */
    protected $input;

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
        $this->input = $input;
        $this->validateArgs();
        $this->save($this->findAll($input), $input['status']);

        return [];
    }

    /**
     * 保存状态
     *
     * @param \Leevel\Collection\Collection $entitys
     * @param string                        $status
     */
    protected function save(Collection $entitys, string $status)
    {
        foreach ($entitys as $entity) {
            $entity->status = $status;
            $this->w->persist($entity);
        }

        $this->w->flush();
    }

    /**
     * 查询符合条件的资源.
     *
     * @param array $input
     *
     * @return \Leevel\Collection\Collection
     */
    protected function findAll(array $input): Collection
    {
        $entitys = $this->w
            ->repository(Resource::class)
            ->findAll(function ($select) use ($input) {
                $select->whereIn('id', $input['ids']);
            });

        if (0 === count($entitys)) {
            throw new BusinessException(__('未发现资源'));
        }

        return $entitys;
    }

    /**
     * 校验基本参数.
     */
    protected function validateArgs()
    {
        $validator = Validate::make(
            $this->input,
            [
                'ids'          => 'required|array',
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
