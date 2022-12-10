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

if (!function_exists('sql_listener')) {
    /**
     * SQL 监听器.
     */
    function sql_listener(Closure $call): void
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

if (!function_exists('success')) {
    /**
     * 正确消息.
     */
    function success(array $data, string $message = '', int $code = 0, array $extend = []): array
    {
        // 非空索引数组不支持写入 success
        if ($data && array_values($data) === $data) {
            return $data;
        }

        // code 前后端可以根据 code 自定义消息
        // message 后端消息内容
        // throw_message 立刻抛出后端消息
        // type 正确消息模板类型
        $success = [
            'code'          => $code,
            'message'       => $message ?: __('操作成功'),
            'throw_message' => true,
            'type'          => 'default',
        ];
        $success = array_merge($success, $extend);
        $data['success'] = $success;

        return $data;
    }
}
