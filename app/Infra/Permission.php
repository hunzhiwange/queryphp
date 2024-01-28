<?php

declare(strict_types=1);

namespace App\Infra;

use App\User\Service\User\Permission as PermissionService;
use App\User\Service\User\PermissionParams;

/**
 * 校验权限.
 */
class Permission
{
    private PermissionCache $permissionCache;

    private string $token;

    /**
     * 构造函数.
     */
    public function __construct(PermissionCache $permissionCache, string $token)
    {
        $this->permissionCache = $permissionCache;
        $this->token = $token;
    }

    /**
     * 校验权限.
     */
    public function handle(string $resource, ?string $method = null): bool
    {
        // 获取权限数据
        $permission = $this->getPermissionData();

        // 超级管理员
        if (\in_array('*', $permission['static'], true)) {
            return true;
        }

        // 所有请求
        if (\in_array($resource, $permission['static'], true)) {
            return true;
        }

        // 带有请求类型
        if ($method && \in_array($method.':'.$resource, $permission['static'], true)) {
            return true;
        }

        // 动态权限
        foreach ($permission['dynamic'] as $p) {
            $p = $this->prepareRegexForWildcard($p);

            // 无请求类型
            if (preg_match($p, $resource, $res)) {
                return true;
            }

            // 带有请求类型
            if ($method && preg_match($p, $method.':'.$resource, $res)) {
                return true;
            }
        }

        return false;
    }

    protected function getPermissionData(): array
    {
        $cacheData = $this->permissionCache->get($this->token);
        // 尝试重新生成权限缓存
        if (false === $cacheData) {
            $params = new PermissionParams([
                'refresh' => 1,
                'token' => $this->token,
            ]);
            $params->id = get_account_id();

            /** @var PermissionService $service */
            $service = \App::make(PermissionService::class);

            return $service->handle($params);
        }

        return $cacheData;
    }

    /**
     * 通配符正则.
     */
    private function prepareRegexForWildcard(string $regex): string
    {
        $regex = preg_quote($regex, '/');

        return '/^'.str_replace('\*', '(\S*)', $regex).'$/';
    }
}
