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
    public function __construct(
        private PermissionCache $permissionCache,
        private UserPermission $permission,
    )
    {
    }

    public function handle(PermissionParams $params): array
    {
        // 刷线缓存
        if ($params->refresh) {
            return $this->getPermission($params->token, $params->id);
        }

        return $this->permissionCache->get($params->token);
    }

    /**
     * 获取权限.
     */
    private function getPermission(string $token, int $userId): array
    {
        $permission = $this->permission->handle(new UserPermissionParams(['user_id' => $userId]));
        $this->permissionCache->set($token, $permission);

        return $permission;
    }
}
