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

use Common\Domain\Entity\User\User;
use Common\Domain\Entity\User\UserRole as EntityUserRole;
use Common\Domain\Service\User\User\PrepareForUser;

/**
 * 更新授权.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.21
 *
 * @version 1.0
 */
trait UserRole
{
    /**
     * 准备数据.
     *
     * @param \Common\Domain\Entity\User\User $user
     *
     * @return array
     */
    protected function prepareData(User $user): array
    {
        return (new PrepareForUser())->handle($user);
    }

    /**
     * 设置用户授权.
     *
     * @param int   $userId
     * @param array $roleId
     */
    protected function setUserRole(int $userId, array $roleId): void
    {
        $existRole = [];
        foreach ($roleId as $rid) {
            $rid = (int) $rid;
            $this->w->replace($this->entityUserRole($userId, $rid));
            $existRole[] = $rid;
        }

        foreach ($this->findRoles($userId) as $r) {
            if (\in_array($r['role_id'], $existRole, true)) {
                continue;
            }
            $this->w->delete($r);
        }
    }

    /**
     * 创建授权实体.
     *
     * @param int $userId
     * @param int $roleId
     *
     * @return \Common\Domain\Entity\User\UserRole
     */
    protected function entityUserRole(int $userId, int $roleId): EntityUserRole
    {
        return new EntityUserRole([
            'user_id' => $userId,
            'role_id' => $roleId,
        ]);
    }
}
