<?php

declare(strict_types=1);

use App\Infra\Proxy\Permission;
use App\Infra\RoadRunnerDump;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\IDatabase;
use Leevel\Database\Proxy\Db;
use Leevel\Di\Container;
use Leevel\Http\Request;
use Leevel\Support\Arr\Only;

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
        // @phpstan-ignore-next-line
        \App::make('event')
            ->register(IDatabase::SQL_EVENT, function (string $event, string $sql) use ($call): void {
                $call($event, $sql);
            })
        ;
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

if (!function_exists('get_company_id')) {
    /**
     * 获取公司 ID.
     */
    function get_company_id(): int
    {
        return (int) \App::make('company_id');
    }
}

if (!function_exists('http_request_value')) {
    /**
     * 获取输入参数 支持过滤和默认值
     *
     * - ThinkPHP 3.2.3 大写 I 方法兼容性代码
     *
     * 使用方法:
     * <code>
     * http_request_value('id',0); 获取 id 参数 自动判断 get 或者 post
     * http_request_value('post.name','','htmlspecialchars'); 获取 $_POST['name']
     * http_request_value('get.'); 获取$_GET
     * </code>
     *
     * @param string $name    变量的名称 支持指定类型
     * @param mixed  $default 不存在的时候默认值
     * @param mixed  $filter  参数过滤方法
     * @param mixed  $datas   要获取的额外数据源
     *
     * @return mixed
     */
    function http_request_value($name, $default = '', $filter = null, $datas = null)
    {
        /** @phpstan-ignore-next-line */
        $request = http_request();

        if (strpos($name, '/')) { // 指定修饰符
            [$name, $type] = explode('/', $name, 2);
        }
        if (strpos($name, '.')) { // 指定参数来源
            [$method, $name] = explode('.', $name, 2);
        } else { // 默认为自动判断
            $method = 'param';
        }

        switch (strtolower($method)) {
            case 'get'    :
                /** @phpstan-ignore-next-line */
                $input = $request->query->all();

                break;

            case 'post'    :
                /** @phpstan-ignore-next-line */
                $input = $request->request->all();

                break;

            case 'param'   :
                // @phpstan-ignore-next-line
                switch ($request->server->get('REQUEST_METHOD')) {
                    case Request::METHOD_POST:
                        /** @phpstan-ignore-next-line */
                        $input = $request->request->all();

                        break;

                    default:
                        /** @phpstan-ignore-next-line */
                        $input = $request->query->all();
                }

                break;

            case 'request' :
                /** @phpstan-ignore-next-line */
                $input = $request->request->all();

                break;

            case 'session' :
                /** @phpstan-ignore-next-line */
                $input = $request->getSession()->all();

                break;

            case 'cookie'  :
                /** @phpstan-ignore-next-line */
                $input = $request->cookies->all();

                break;

            case 'server'  :
                /** @phpstan-ignore-next-line */
                $input = $request->server->all();

                break;

            case 'data'    :
                $input = $datas;

                break;

            default:
                return null;
        }
        if ('' === $name) { // 获取全部变量
            $data = $input;
            $filters = $filter ?? [];
            if ($filters) {
                if (is_string($filters)) {
                    $filters = explode(',', $filters);
                }
                foreach ((array) $filters as $filter) {
                    /** @phpstan-ignore-next-line */
                    $data = array_map_recursive($filter, $data); // 参数过滤
                }
            }
        } elseif (isset($input[$name])) { // 取值操作
            $data = $input[$name];
            $filters = $filter ?? [];
            if ($filters) {
                if (is_string($filters)) {
                    if (str_starts_with($filters, '/') && 1 !== preg_match($filters, (string) $data)) {
                        // 支持正则验证
                        return $default ?? null;
                    }
                    $filters = explode(',', $filters);
                } elseif (is_int($filters)) {
                    $filters = [$filters];
                }

                if (is_array($filters)) {
                    foreach ($filters as $filter) {
                        if (function_exists($filter)) {
                            $data = is_array($data) ? array_map_recursive($filter, $data) : $filter($data); // 参数过滤
                        } else {
                            if (!is_int($filter)) {
                                $filter = filter_id($filter);
                                if (false === $filter) {
                                    throw new \Exception('Filter does not exist.');
                                }
                            }
                            $data = filter_var($data, $filter);
                            if (false === $data) {
                                return $default ?? null;
                            }
                        }
                    }
                }
            }
            if (!empty($type)) {
                switch (strtolower($type)) {
                    case 'a':	// 数组
                        $data = (array) $data;

                        break;

                    case 'd':	// 数字
                        $data = (int) $data;

                        break;

                    case 'f':	// 浮点
                        $data = (float) $data;

                        break;

                    case 'b':	// 布尔
                        $data = (bool) $data;

                        break;

                    case 's':   // 字符串
                    default:
                        $data = (string) $data;
                }
            }
        } else { // 变量默认值
            $data = $default ?? null;
        }

        return $data;
    }
}

if (!function_exists('http_request')) {
    /**
     * 获取请求对象.
     */
    function http_request(): Request
    {
        // @phpstan-ignore-next-line
        return container()->make(Request::class);
    }
}

if (!function_exists('array_map_recursive')) {
    /** @phpstan-ignore-next-line */
    function array_map_recursive(callable $filter, array $data): array
    {
        $result = [];
        foreach ($data as $key => $val) {
            $result[$key] = is_array($val)
                ? array_map_recursive($filter, $val)
                : call_user_func($filter, $val);
        }

        return $result;
    }
}

if (!function_exists('container')) {
    /**
     * 获取容器对象.
     */
    function container(): Container
    {
        // @phpstan-ignore-next-line
        return Container::singletons();
    }
}

if (!function_exists('get_current_date')) {
    /**
     * 获取当前时间.
     */
    function get_current_date(): string
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
            'code' => $code,
            'message' => $message ?: __('操作成功'),
            'throw_message' => true,
            'type' => 'default',
        ];
        $success = array_merge($success, $extend);
        $data['success'] = $success;

        return $data;
    }
}

if (!function_exists('rr_dump')) {
    /**
     * 调试 RoadRunner 变量.
     */
    function rr_dump(mixed $var, mixed ...$moreVars): mixed
    {
        return RoadRunnerDump::handle($var, ...$moreVars);
    }
}

if (!function_exists('transaction')) {
    /**
     * 事务处理.
     */
    function transaction(Closure $businessLogic): mixed
    {
        return Db::transaction($businessLogic);
    }
}

if (!function_exists('bcadd_compatibility')) {
    function bcadd_compatibility(float|int|string $num1, float|int|string $num2, int $scale = 2): float
    {
        return (float) bcadd((string) $num1, (string) $num2, $scale);
    }
}

if (!function_exists('bcdiv_compatibility')) {
    function bcdiv_compatibility(float|int|string $num1, float|int|string $num2, int $scale = 2): float
    {
        return (float) bcdiv((string) $num1, (string) $num2, $scale);
    }
}

if (!function_exists('bcmul_compatibility')) {
    function bcmul_compatibility(float|int|string $num1, float|int|string $num2, int $scale = 2): float
    {
        return (float) bcmul((string) $num1, (string) $num2, $scale);
    }
}

if (!function_exists('bcsub_compatibility')) {
    function bcsub_compatibility(float|int|string $num1, float|int|string $num2, int $scale = 2): float
    {
        return (float) bcsub((string) $num1, (string) $num2, $scale);
    }
}

if (!function_exists('bccomp_compatibility')) {
    function bccomp_compatibility(float|int|string $num1, float|int|string $num2, int $scale = 2): int
    {
        return bccomp((string) $num1, (string) $num2, $scale);
    }
}

if (!function_exists('create_data_id')) {
    function create_data_id(array $data, array $keys = []): string
    {
        if (empty($keys)) {
            $keys = array_keys($data);
        }

        $data = Only::handle($data, $keys);
        ksort($data);

        return http_build_query($data);
    }
}

if (!function_exists('array_key_sort')) {
    /**
     * 二维数组根据某个字段排序.
     */
    function array_key_sort(array $array, string $key, int $sort = SORT_DESC): array
    {
        $keyValue = [];
        foreach ($array as $k => $v) {
            $keyValue[$k] = $v[$key];
        }
        array_multisort($keyValue, $sort, $array);

        return $array;
    }
}

if (!function_exists('get_entity_import_fields')) {
    /**
     * 获取导入基础字段.
     */
    function get_entity_import_fields(string $entityClass): array
    {
        if (!is_subclass_of($entityClass, \Leevel\Database\Ddd\Entity::class)) {
            throw new \Exception(sprintf('Entity class %s is invalid.', $entityClass));
        }

        $fields = array_keys($entityClass::fields());

        $exceptFields = [
            'id',
            'company_id',
            'create_at',
            'update_at',
            'delete_at',
            'create_account',
            'update_account',
            'version',
        ];

        return array_diff($fields, $exceptFields);
    }
}

if (!function_exists('format_by_default_data')) {
    /**
     * 根据默认值格式化数据.
     */
    function format_by_default_data(array $data, array $defaultData): array
    {
        $defaultType = [];
        foreach ($data as &$item) {
            foreach ($item as $field => &$value) {
                if (!isset($defaultData[$field])) {
                    continue;
                }

                if ('' === $value) {
                    $value = $defaultData[$field];
                } else {
                    if (!isset($defaultType[$field])) {
                        $defaultType[$field] = gettype($defaultData[$field]);
                    }

                    $value = match ($defaultType[$field]) {
                        'NULL' => null,
                        'boolean' => (bool) $value,
                        'integer' => (int) $value,
                        'double' => (float) $value,
                        'string' => (string) $value,
                        'array' => (array) $value,
                        'object' => (object) $value,
                        default => throw new \Exception('Unsupported default value type.'),
                    };
                }
            }
        }

        return $data;
    }
}

if (!function_exists('get_entity_default_data')) {
    /**
     * 获取实体默认数据.
     */
    function get_entity_default_data(string $entityClass): array
    {
        if (!is_subclass_of($entityClass, \Leevel\Database\Ddd\Entity::class)) {
            throw new \Exception(sprintf('Entity class %s is invalid.', $entityClass));
        }

        $defaultData = [];
        foreach ($entityClass::fields() as $field => $v) {
            if (isset($v[Entity::COLUMN_STRUCT])
                && array_key_exists('default', $v[Entity::COLUMN_STRUCT])) {
                $defaultData[$field] = $v[Entity::COLUMN_STRUCT]['default'];
            }
        }

        return $defaultData;
    }
}
