<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Admin\Infra\PermissionCache;

/**
 * 用户权限数据.
 */
class Permission
{
    /**
     * 构造函数.
     */
    public function __construct(private PermissionCache $permissionCache, private UserPermission $permission)
    {
    }

    public function handle(array $input): array
    {
        // 刷线缓存
        if ($input['refresh']) {
            return $this->getPermission($input['token'], (int) $input['id']);
        }

        return $this->permissionCache->get($input['token']);
    }

    /**
     * 获取权限.
     */
    private function getPermission(string $token, int $userId): array
    {
        $permission = $this->permission->handle(['user_id' => $userId]);
        $this->permissionCache->set($token, $permission);

        return $permission;
    }
}
