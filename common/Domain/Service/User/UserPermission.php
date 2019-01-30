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

use Common\Domain\Entity\User;
use Leevel\Database\Ddd\IUnitOfWork;

/**
 * 用户权限查询.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.21
 *
 * @version 1.0
 */
class UserPermission
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
        $user = $this->findUser((int) $input['user_id']);

        $data = $this->parsePermission($user);

        $data = $this->normalizePermission($data);

        return $data;
    }

    /**
     * 格式化权限数据.
     *
     * @param array $data
     *
     * @return array
     */
    protected function normalizePermission(array $data): array
    {
        $permission = ['static' => [], 'dynamic' => []];

        foreach ($data as $v) {
            if ('*' !== $v && false !== strpos($v, '*')) {
                $permission['dynamic'][] = $v;
            } else {
                $permission['static'][] = $v;
            }
        }

        return $permission;
    }

    /**
     * 查询权限数据.
     *
     * @param \Common\Domain\Entity\User $user
     *
     * @return array
     */
    protected function parsePermission(User $user): array
    {
        $data = [];

        $roles = $user->role;

        if (\count($roles) > 0) {
            foreach ($roles as $r) {
                $permissions = $r->permission;

                if (\count($permissions) > 0) {
                    foreach ($permissions as $p) {
                        $resources = $p->resource;

                        if (\count($resources) > 0) {
                            $resourceData = array_unique(array_column($resources->toArray(), 'identity'));

                            $data = array_merge($data, $resourceData);
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * 查找用户实体.
     *
     * @param int $id
     *
     * @return \Common\Domain\Entity\User
     */
    protected function findUser(int $id): User
    {
        return $this->w->repository(User::class)->findOrFail($id);
    }
}
