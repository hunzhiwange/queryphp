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

namespace Common\Domain\Service\User\User;

use Common\Domain\Entity\User\User;
use Leevel\Database\Ddd\IUnitOfWork;

/**
 * 用户删除.
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
        $this->remove($this->find($input['id']));

        return [];
    }

    /**
     * 删除实体.
     *
     * @param \Common\Domain\Entity\User\User $entity
     */
    protected function remove(User $entity)
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
     * @return \Common\Domain\Entity\User\User
     */
    protected function find(int $id): User
    {
        return $this->w->repository(User::class)->findOrFail($id);
    }
}
