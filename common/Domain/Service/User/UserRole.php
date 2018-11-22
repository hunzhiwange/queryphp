<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Domain\Service\User;

use Common\Domain\Entity\UserRole as UserRoles;
use Leevel\Database\Ddd\IUnitOfWork;

/**
 * 用户授权.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.21
 *
 * @version 1.0
 */
class UserRole
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
        $items = $this->w->repository(UserRoles::class)->findAll(function ($select) use ($input) {
            $select->where('user_id', $input['user_id']);
        });

        //$this->w->flush();

        //print_r($this->w);
        //die;
        $existRole = [];

        foreach ($input['userRole'] as $roleId) {
            $this->w->replace(new UserRoles([
                'user_id' => $input['user_id'],
                'role_id' => $roleId,
            ]));

            $existRole[] = $roleId;

            // foreach ($items as $item) {
            //     $this->w->delete($item);
            // }
        }

        foreach ($items as $item) {
            if (in_array($item['role_id'], $existRole, true)) {
                continue;
            }

            $this->w->delete($item);
        }

        //dump($this->w);
        //    die;
        return [];
        die;
        die;

        return $this->save($input)->toArray();
    }

    /**
     * 保存.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\Permission
     */
    protected function save(array $input): Permission
    {
        $this->w->persist($resource = $this->entity($input))->

        flush();

        return $resource;
    }

    /**
     * 创建实体.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\Permission
     */
    protected function entity(array $input): Permission
    {
        return new Permission($this->data($input));
    }

    /**
     * 组装实体数据.
     *
     * @param array $input
     *
     * @return array
     */
    protected function data(array $input): array
    {
        return [
            'name'       => trim($input['name']),
            'identity'   => trim($input['identity']),
            'status'     => $input['status'],
        ];
    }
}
