<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Collection\Collection;
use Leevel\Collection\TypedIntArray;
use Leevel\Database\Ddd\Select;
use Leevel\Database\Ddd\UnitOfWork;
use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserRole as EntityUserRole;

/**
 * 用户授权角色.
 */
class Role
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(RoleParams $params): array
    {
        return $this->prepareData($this->save($params));
    }

    /**
     * 准备数据.
     */
    private function prepareData(User $user): array
    {
        return (new PrepareForUser())->handle($user);
    }

    /**
     * 保存.
     */
    private function save(RoleParams $params): User
    {
        $entity = $this->entity($params->id);
        $this->setUserRole($params->id, $params->roleId);
        $this->w->flush();

        return $entity;
    }

    /**
     * 查找存在角色.
     */
    private function findRoles(int $userId): Collection
    {
        return $this->w
            ->repository(EntityUserRole::class)
            ->findAll(function (Select $select) use ($userId) {
                $select->where('user_id', $userId);
            });
    }

    /**
     * 验证参数.
     */
    private function entity(int $userId): User
    {
        return $this->find($userId);
    }

    /**
     * 查找实体.
     */
    private function find(int $id): User
    {
        return $this->w->repository(User::class)->findOrFail($id);
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
