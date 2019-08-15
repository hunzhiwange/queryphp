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

namespace Common\Domain\Service\User\Role;

use Closure;
use Common\Domain\Entity\User\Role;
use Leevel\Database\Ddd\IEntity;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Database\Ddd\Select;

/**
 * 角色列表.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.23
 *
 * @version 1.0
 */
class Index
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
        $repository = $this->w->repository(Role::class);

        list($page, $entitys) = $repository->findPage(
            (int) ($input['page'] ?: 1),
            (int) ($input['size'] ?? 10),
            $this->condition($input)
        );

        $data['page'] = $page;
        $data['data'] = $entitys->toArray();

        return $data;
    }

    /**
     * 查询条件.
     *
     * @param array $input
     *
     * @return \Closure
     */
    protected function condition(array $input): Closure
    {
        return function (Select $select, IEntity $entity) use ($input) {
            if ($input['key']) {
                $select->where(function ($select) use ($input) {
                    $select
                        ->orWhere('name', 'like', '%'.$input['key'].'%')
                        ->orWhere('identity', 'like', '%'.$input['key'].'%');
                });
            }

            if ($input['status'] || '0' === $input['status']) {
                $select->where('status', $input['status']);
            }

            $select->orderBy('id DESC');
        };
    }
}
