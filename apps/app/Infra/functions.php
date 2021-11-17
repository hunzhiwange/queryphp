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

if (!function_exists('inject_company')) {
    /**
     * 注入公司信息.
     */
    function inject_company(array &$data): array
    {
        $companyId = \App::make('company_id');
        foreach ($data as &$v) {
            if (!isset($v['company_id'])) {
                $v['company_id'] = $companyId;
            }
        }

        return $data;
    }
}

if (!function_exists('get_current_date')) {
    /**
     * 获取当前时间.
     */
    function get_current_date()
    {
        return date('Y-m-d H:i:s');
    }
}
