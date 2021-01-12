<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserRole as EntityUserRole;
use Leevel\Collection\TypedIntArray;

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
    private function setUserRole(int $userId, TypedIntArray $userRole): void
    {
        $roles = $this->findRoles($userId);
        $existRoleId = array_column($roles->toArray(), 'role_id');
        foreach ($userRole as $rid) {
            if (!\in_array($rid, $existRoleId, true)) {
                $this->w->create($this->entityUserRole($userId, $rid));
            }
        }

        $roleId = $userRole->toArray();
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
