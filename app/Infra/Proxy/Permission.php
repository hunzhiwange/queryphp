<?php

declare(strict_types=1);

namespace App\Infra\Proxy;

use App\Infra\Permission as AdminPermisson;
use Leevel\Di\Container;

/**
 * 代理 Permission.
 *
 *  @method static bool  handle(string $resource, ?string $method = null)
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
        // @phpstan-ignore-next-line
        return Container::singletons()->make('permission');
    }
}
