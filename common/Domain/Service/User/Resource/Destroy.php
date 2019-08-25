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
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Validate\Proxy\Validate;

/**
 * 资源删除.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class Destroy
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
        $this->remove($this->find($input['id']));

        return [];
    }

    /**
     * 删除实体.
     *
     * @param \Common\Domain\Entity\User\Resource $entity
     */
    protected function remove(Resource $entity)
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
     * @return \Common\Domain\Entity\User\Resource
     */
    protected function find(int $id): Resource
    {
        return $this->w->repository(Resource::class)->findOrFail($id);
    }

    /**
     * 校验基本参数.
     */
    protected function validateArgs()
    {
        $validator = Validate::make(
            $this->input,
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
