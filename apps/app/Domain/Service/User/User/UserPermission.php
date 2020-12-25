<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 用户权限查询.
 */
class UserPermission
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(array $input): array
    {
        $user = $this->findUser((int) $input['user_id']);
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
     */
    private function parsePermission(User $user): array
    {
        $data = [];
        if (\count($roles = $user->role) > 0) {
            foreach ($roles as $r) {
                if (\count($permissions = $r->permission) > 0) {
                    foreach ($permissions as $p) {
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
            ->repository(User::class)
            ->eager(['role.permission.resource'])
            ->where('status', 1)
            ->findOrFail($id);
    }
}
