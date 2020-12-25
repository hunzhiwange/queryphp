<?php

declare(strict_types=1);

use App\Infra\Proxy\Permission;
use Leevel\Database\IDatabase;

if (!function_exists('permission')) {
    /**
     * 校验权限.
     */
    function permission(string $resource, ?string $method = null): bool
    {
        return Permission::handle($resource, $method);
    }
}

if (!function_exists('sql')) {
    /**
     * SQL 监听器.
     */
    function sql(Closure $call): void
    {
        \App::make('event')
            ->register(IDatabase::SQL_EVENT, function (string $event, string $sql) use ($call): void {
                $call($event, $sql);
            });
    }
}
