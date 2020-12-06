<?php

declare(strict_types=1);

namespace Common\Infra\Proxy;

use Admin\Infra\Permission as AdminPermisson;
use Leevel\Di\Container;

/**
 * 代理 Permission.
 */
class Permission
{
    /**
     * call.
     *
     * @return mixed
     */
    public static function __callStatic(string $method, array $args)
    {
        return self::proxy()->{$method}(...$args);
    }

    /**
     * 代理服务.
     */
    public static function proxy(): AdminPermisson
    {
        return Container::singletons()->make('permission');
    }
}
