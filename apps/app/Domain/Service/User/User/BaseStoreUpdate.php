<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserRole as EntityUserRole;

trait BaseStoreUpdate
{
    /**
     * 准备数据.
     */
    private function prepareData(User $user): array
    {
        return (new PrepareForUser())->handle($user);
    }

    /**
     * 设置用户授权.
     */
    private function setUserRole(int $userId, array $roleId): void
    {
        $roles = $this->findRoles($userId);
        $existRoleId = array_column($roles->toArray(), 'role_id');
        foreach ($roleId as &$rid) {
            if (!\in_array($rid, $existRoleId, true)) {
                $this->w->create($this->entityUserRole($userId, $rid));
            }
        }

        foreach ($roles as $r) {
            if (\in_array($r['role_id'], $roleId, true)) {
                continue;
            }
            $this->w->delete($r);
        }
    }

    /**
     * 创建授权实体.
     */
    private function entityUserRole(int $userId, int $roleId): EntityUserRole
    {
        return new EntityUserRole([
            'user_id' => $userId,
            'role_id' => $roleId,
        ]);
    }
}
