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

namespace Admin\Infra;

/**
 * 校验权限.
 */
class Permission
{
    /**
     * 权限数据.
     */
    private array $permission = [];

    /**
     * 构造函数.
     */
    public function __construct(PermissionCache $permission, string $token)
    {
        $this->permission = $permission->get($token);

        if (!\is_array($this->permission['static'])) {
            $this->permission['static'] = [];
        }

        if (!\is_array($this->permission['dynamic'])) {
            $this->permission['dynamic'] = [];
        }
    }

    /**
     * 校验权限.
     */
    public function handle(string $resource, ?string $method = null): bool
    {
        // 超级管理员
        if (\in_array('*', $this->permission['static'], true)) {
            return true;
        }

        // 所有请求
        if (\in_array($resource, $this->permission['static'], true)) {
            return true;
        }

        // 带有请求类型
        if ($method && \in_array($method.':'.$resource, $this->permission['static'], true)) {
            return true;
        }

        // 动态权限
        foreach ($this->permission['dynamic'] as $p) {
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

    /**
     * 通配符正则.
     */
    private function prepareRegexForWildcard(string $regex): string
    {
        $regex = preg_quote($regex, '/');
        $regex = '/^'.str_replace('\*', '(\S*)', $regex).'$/';

        return $regex;
    }
}
