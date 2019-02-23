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

namespace Common\Domain\Service\User;

use Common\Domain\Entity\User;
use Common\Domain\Entity\UserRole as EntityUserRole;
use Leevel\Auth\Hash;
use Leevel\Collection\Collection;
use Leevel\Database\Ddd\IUnitOfWork;

/**
 * 用户更新授权.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.21
 *
 * @version 1.0
 */
class UserRoleUpdate
{
    use UserRole;

    /**
     * 事务工作单元.
     *
     * @var \Leevel\Database\Ddd\IUnitOfWork
     */
    protected $w;

    /**
     * Hash 组件.
     *
     * @var \Leevel\Auth\Hash
     */
    protected $hash;

    /**
     * 构造函数.
     *
     * @param \Leevel\Database\Ddd\IUnitOfWork $w
     * @param \Leevel\Auth\Hash                $hash
     */
    public function __construct(IUnitOfWork $w, Hash $hash)
    {
        $this->w = $w;
        $this->hash = $hash;
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
        return $this->prepareData($this->save($input));
    }

    /**
     * 保存.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\User
     */
    protected function save(array $input): User
    {
        $this->w->persist($entity = $this->entity($input));

        $this->setUserRole((int) $input['id'], $input['userRole']);

        $this->w->flush();

        $entity->refresh();

        return $entity;
    }

    /**
     * 查找存在角色.
     *
     * @param int $userId
     *
     * @return Leevel\Collection\Collection
     */
    protected function findRoles(int $userId): Collection
    {
        return $this->w->repository(EntityUserRole::class)->
        findAll(function ($select) use ($userId) {
            $select->where('user_id', $userId);
        });
    }

    /**
     * 验证参数.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\User
     */
    protected function entity(array $input): User
    {
        $entity = $this->find((int) $input['id']);

        $entity->withProps($this->data($input));

        return $entity;
    }

    /**
     * 查找实体.
     *
     * @param int $id
     *
     * @return \Common\Domain\Entity\User
     */
    protected function find(int $id): User
    {
        return $this->w->repository(User::class)->findOrFail($id);
    }

    /**
     * 创建密码
     *
     * @param string $password
     *
     * @return string
     */
    protected function createPassword(string $password): string
    {
        return $this->hash->password($password);
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
        $data = [
            'identity'   => trim($input['identity']),
            'status'     => $input['status'],
        ];

        $password = trim($input['password']);

        if ($password) {
            $data['password'] = $this->createPassword($password);
        }

        return $data;
    }
}
