<?php

declare(strict_types=1);

namespace App\User\Service\User;

use App\User\Entity\User;
use App\User\Entity\UserStatusEnum;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 用户权限查询.
 */
class UserPermission
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(UserPermissionParams $params): array
    {
        $user = $this->findUser($params->userId);
        $data = $this->parsePermission($user);

        return $this->normalizePermission($data);
    }

    /**
     * 格式化权限数据.
     */
    private function normalizePermission(array $data): array
    {
        $permission = ['static' => [], 'dynamic' => []];
        foreach ($data as $v) {
            if ('*' !== $v && str_contains($v, '*')) {
                $permission['dynamic'][] = $v;
            } else {
                $permission['static'][] = $v;
            }
        }

        return $permission;
    }

    /**
     * 查询权限数据.
     */
    private function parsePermission(User $user): array
    {
        $data = [];
        if (\count($roles = $user->role) > 0) {
            /** @var \App\User\Entity\Role $r */
            foreach ($roles as $r) { // @phpstan-ignore-line
                if (\count($permissions = $r->permission) > 0) {
                    /** @var \App\User\Entity\Permission $p */
                    foreach ($permissions as $p) { // @phpstan-ignore-line
                        if (\count($resources = $p->resource) > 0) {
                            $resourceData = array_unique(array_column($resources->toArray(), 'num'));
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
     */
    private function findUser(int $id): User
    {
        return $this->w
            ->repository(\App\User\Entity\User::class)
            ->eager(['role.permission.resource'])
            ->where('status', UserStatusEnum::ENABLE->value)
            ->findOrFail($id)
        ;
    }
}
