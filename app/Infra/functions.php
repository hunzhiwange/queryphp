<?php

declare(strict_types=1);

use App\Company\Service\PlatformCompany;
use App\Infra\Entity\AccountField;
use App\Infra\Exceptions\BusinessException;
use App\Infra\Exceptions\ErrorCode;
use App\Infra\GenerateDocument;
use App\Infra\Proxy\Permission;
use App\Infra\RoadRunnerDump;
use App\Infra\Service\ApiQL\ApiQL;
use App\Infra\Service\ApiQL\ApiQLBatch;
use App\Infra\Service\ApiQL\ApiQLBatchParams;
use App\Infra\Service\ApiQL\ApiQLParams;
use App\Infra\Service\ApiQL\ApiQLStore;
use App\Infra\Service\ApiQL\ApiQLStoreParams;
use App\Infra\Service\ApiQL\ApiQLUpdate;
use App\Infra\Service\ApiQL\ApiQLUpdateParams;
use App\Infra\Service\Support\ReadParams;
use Leevel\Config\Proxy\Config;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Database\IDatabase;
use Leevel\Di\Container;
use Leevel\Http\Request;
use Leevel\Support\Arr\Only;
use Leevel\Support\Str\UnCamelize;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('enabled_co')) {
    /**
     * 是否起用协程.
     */
    function enabledCoroutine(): bool
    {
        return container()->enabledCoroutine();
    }
}

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

if (!function_exists('batch_inject_company')) {
    /**
     * 批量注入公司信息.
     */
    function batch_inject_company(array $data): array
    {
        $baseData = [
            'company_id' => get_company_id(),
        ];
        foreach ($data as &$v) {
            $v = array_merge($baseData, $v);
        }

        return $data;
    }
}

if (!function_exists('batch_inject_platform')) {
    /**
     * 批量注入平台信息.
     */
    function batch_inject_platform(array $data): array
    {
        $baseData = [
            'platform_id' => get_platform_id(),
        ];
        foreach ($data as &$v) {
            $v = array_merge($baseData, $v);
        }

        return $data;
    }
}

if (!function_exists('batch_inject_account')) {
    /**
     * 批量注入账号信息.
     */
    function batch_inject_account(array $data, array $injectFields): array
    {
        $accountId = get_account_id();
        $accountName = get_account_name();

        $injectData = [];
        if (in_array(AccountField::CREATE_ACCOUNT, $injectFields, true)) {
            $injectData[AccountField::CREATE_ACCOUNT] = $accountId;
        }

        if (in_array(AccountField::UPDATE_ACCOUNT, $injectFields, true)) {
            $injectData[AccountField::UPDATE_ACCOUNT] = $accountId;
        }

        if (in_array(AccountField::CREATE_ACCOUNT_NAME, $injectFields, true)) {
            $injectData[AccountField::CREATE_ACCOUNT_NAME] = $accountName;
        }

        if (in_array(AccountField::UPDATE_ACCOUNT_NAME, $injectFields, true)) {
            $injectData[AccountField::UPDATE_ACCOUNT_NAME] = $accountName;
        }

        foreach ($data as &$v) {
            $v = array_merge($injectData, $v);
        }

        return $data;
    }
}

if (!function_exists('inject_account')) {
    /**
     * 注入账号信息.
     */
    function inject_account(array $data, array $injectFields): array
    {
        return batch_inject_account([$data], $injectFields)[0];
    }
}

if (!function_exists('inject_company')) {
    /**
     * 注入公司信息.
     */
    function inject_company(array $data): array
    {
        return batch_inject_company([$data])[0];
    }
}

if (!function_exists('inject_platform')) {
    /**
     * 注入平台信息.
     */
    function inject_platform(array $data): array
    {
        return batch_inject_platform([$data])[0];
    }
}

if (!function_exists('inject_platform_company')) {
    /**
     * 注入平台和公司信息.
     */
    function inject_platform_company(array $data): array
    {
        return batch_inject_platform_company([$data])[0];
    }
}

if (!function_exists('batch_inject_platform_company')) {
    /**
     * 批量注入平台和公司信息.
     */
    function batch_inject_platform_company(array $data): array
    {
        $baseData = [
            'platform_id' => get_platform_id(),
            'company_id' => get_company_id(),
        ];
        foreach ($data as &$v) {
            $v = array_merge($baseData, $v);
        }

        return $data;
    }
}

if (!function_exists('batch_inject_common_data')) {
    /**
     * 批量注入通用信息.
     */
    function batch_inject_common_data(string $entityClass, array $data): array
    {
        if (!is_subclass_of($entityClass, Entity::class)) {
            return $data;
        }

        // 公司信息
        if ($entityClass::hasField('company_id')) {
            $data = batch_inject_company($data);
        }

        // 平台信息
        if ($entityClass::hasField('platform_id')) {
            $data = batch_inject_platform($data);
        }

        // 账号信息
        $injectAccountField = [];
        foreach ([
            AccountField::CREATE_ACCOUNT_NAME,
            AccountField::UPDATE_ACCOUNT_NAME,
            AccountField::CREATE_ACCOUNT,
            AccountField::UPDATE_ACCOUNT,
        ] as $field) {
            if ($entityClass::hasField($field)) {
                $injectAccountField[] = $field;
            }
        }
        if ($injectAccountField) {
            $data = batch_inject_account($data, $injectAccountField);
        }

        return $data;
    }
}

if (!function_exists('batch_inject_common_update_data')) {
    /**
     * 批量注入通用更新信息.
     */
    function batch_inject_common_update_data(string $entityClass, array $data): array
    {
        if (!is_subclass_of($entityClass, Entity::class)) {
            return $data;
        }

        // 账号信息
        $injectAccountField = [];
        foreach ([
            AccountField::UPDATE_ACCOUNT_NAME,
            AccountField::UPDATE_ACCOUNT,
        ] as $field) {
            if ($entityClass::hasField($field)) {
                $injectAccountField[] = $field;
            }
        }
        if ($injectAccountField) {
            $data = batch_inject_account($data, $injectAccountField);
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

if (!function_exists('get_platform_id')) {
    /**
     * 获取平台 ID.
     */
    function get_platform_id(): int
    {
        return (int) \App::make('platform_id');
    }
}

if (!function_exists('get_client_id')) {
    /**
     * 获取客户 ID.
     */
    function get_client_id(): int
    {
        return (int) \App::make('client_id');
    }
}

if (!function_exists('get_account_id')) {
    /**
     * 获取账号ID.
     */
    function get_account_id(): int
    {
        return (int) \App::make('account_id');
    }
}

if (!function_exists('get_account_name')) {
    /**
     * 获取账号名字.
     */
    function get_account_name(): string
    {
        return (string) \App::make('account_name');
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
        $request = container()->make(Request::class);
        if (!$request instanceof Request) {
            throw new \Exception('Request is invalid.');
        }

        return $request;
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

if (!function_exists('success_message')) {
    /**
     * 正确消息.
     */
    function success_message(array $data, string $message = '', int $code = 0, array $extend = []): array
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

if (!function_exists('bc_add')) {
    function bc_add(float|int|string $num1, float|int|string $num2, int $scale = 6): float
    {
        return (float) bcadd(bc_quantity($num1), bc_quantity($num2), $scale);
    }
}

if (!function_exists('bc_div')) {
    function bc_div(float|int|string $num1, float|int|string $num2, int $scale = 6): float
    {
        return (float) bcdiv(bc_quantity($num1), bc_quantity($num2), $scale);
    }
}

if (!function_exists('bc_mul')) {
    function bc_mul(float|int|string $num1, float|int|string $num2, int $scale = 6): float
    {
        return (float) bcmul(bc_quantity($num1), bc_quantity($num2), $scale);
    }
}

if (!function_exists('bc_sub')) {
    function bc_sub(float|int|string $num1, float|int|string $num2, int $scale = 6): float
    {
        return (float) bcsub(bc_quantity($num1), bc_quantity($num2), $scale);
    }
}

if (!function_exists('bc_mod')) {
    function bc_mod(float|int|string $num1, float|int|string $num2, int $scale = 6): float
    {
        return (float) bcmod(bc_quantity($num1), bc_quantity($num2), $scale);
    }
}

if (!function_exists('bc_comp')) {
    function bc_comp(float|int|string $num1, float|int|string $num2, int $scale = 6): int
    {
        return bccomp(bc_quantity($num1), bc_quantity($num2), $scale);
    }
}

if (!function_exists('bc_abs')) {
    function bc_abs(float|int|string $num1, int $scale = 6): float
    {
        if (1 === bc_comp($num1, 0)) {
            return bc_add($num1, 0, $scale);
        }

        return bc_mul($num1, -1, $scale);
    }
}

if (!function_exists('format_decimal')) {
    function format_decimal(float|int|string $num): float
    {
        return (float) bc_quantity($num, 8, false);
    }
}

if (!function_exists('format_images')) {
    function format_images(string $images): string
    {
        if (!$images) {
            return '';
        }

        return Config::get('attachments_url').'/'.$images;
    }
}

if (!function_exists('format_images_list')) {
    function format_images_list(string $images): string
    {
        if (!$images) {
            return '';
        }

        $imagesList = explode(',', $images);
        $attachmentsUrl = Config::get('attachments_url');
        $imagesList = array_map(fn (string $v): string => $attachmentsUrl.'/'.$v, $imagesList);

        return implode(',', $imagesList);
    }
}

if (!function_exists('bc_quantity')) {
    function bc_quantity(float|int|string $num, int $scale = 6, bool $forceWithoutDecimalZero = true): string
    {
        if (!is_float($num)) {
            $num = (float) $num;
        }

        $result = number_format($num, $scale, '.', '');
        if ($forceWithoutDecimalZero) {
            return $result;
        }

        $withoutDecimalZero = !container()->has('without_decimal_zero') || (bool) container()->make('without_decimal_zero');
        if (!$withoutDecimalZero) {
            return $result;
        }

        return (string) (float) $result;
    }
}

if (!function_exists('bc_comp_quantity')) {
    function bc_comp_quantity(float|int|string $num1, float|int|string $num2): int
    {
        return bc_comp($num1, $num2, quantity_scale());
    }
}

if (!function_exists('bc_comp_price')) {
    function bc_comp_price(float|int|string $num1, float|int|string $num2): int
    {
        return bc_comp($num1, $num2, price_scale());
    }
}

if (!function_exists('bc_comp_pay_price')) {
    function bc_comp_pay_price(float|int|string $num1, float|int|string $num2): int
    {
        return bc_comp($num1, $num2, pay_price_scale());
    }
}

if (!function_exists('quantity_scale')) {
    function quantity_scale(): int
    {
        return container()->has('quantity_scale') ? (int) container()->make('quantity_scale') : 2;
    }
}

if (!function_exists('price_scale')) {
    function price_scale(): int
    {
        return container()->has('price_scale') ? (int) container()->make('price_scale') : 2;
    }
}

if (!function_exists('pay_price_scale')) {
    function pay_price_scale(): int
    {
        return container()->has('pay_price_scale') ? (int) container()->make('pay_price_scale') : 2;
    }
}

if (!function_exists('format_quantity')) {
    /**
     * 格式化数量.
     *
     * - 存入数据库不做任何处理，仅仅读取的时候进行格式化
     */
    function format_quantity(float|int|string $quantity): string
    {
        return bc_quantity($quantity, quantity_scale(), false);
    }
}

if (!function_exists('format_price')) {
    /**
     * 格式化价格.
     *
     * - 存入数据库不做任何处理，仅仅读取的时候进行格式化
     */
    function format_price(float|int|string $price): string
    {
        return bc_quantity($price, price_scale(), false);
    }
}

if (!function_exists('format_pay_price')) {
    /**
     * 格式化支付价格.
     *
     * - 支付只能进行两位小数判断
     * - 存入数据库不做任何处理，仅仅读取的时候进行格式化
     */
    function format_pay_price(float|int|string $price): string
    {
        return bc_quantity($price, pay_price_scale(), false);
    }
}

if (!function_exists('allocation_price')) {
    /**
     * 分摊价格.
     */
    function allocation_price(array &$proportionData, float $totalQuantity): array
    {
        return \App\Infra\Helper\Allocation::handle($proportionData, $totalQuantity, price_scale());
    }
}

if (!function_exists('allocation_pay_price')) {
    /**
     * 分摊支付价格.
     *
     * - 一般价格分摊的精度直接取两位即可，与支付精度保持一致
     */
    function allocation_pay_price(array &$proportionData, float $totalQuantity): array
    {
        return \App\Infra\Helper\Allocation::handle($proportionData, $totalQuantity, pay_price_scale());
    }
}

if (!function_exists('allocation_quantity')) {
    /**
     * 分摊数量.
     *
     * - 数量分摊的精度直接取设置即可
     */
    function allocation_quantity(array &$proportionData, float $totalQuantity): array
    {
        return \App\Infra\Helper\Allocation::handle($proportionData, $totalQuantity, quantity_scale());
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
        check_entity_class($entityClass);

        $fields = array_keys($entityClass::fields());

        $exceptFields = [
            'company_id',
            'create_at',
            'update_at',
            'delete_at',
            AccountField::CREATE_ACCOUNT,
            AccountField::UPDATE_ACCOUNT,
            AccountField::CREATE_ACCOUNT_NAME,
            AccountField::UPDATE_ACCOUNT_NAME,
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
                // 过滤掉值为 null 的字段
                // 去掉没有默认值的字段
                if (null === $value || !isset($defaultData[$field])) {
                    continue;
                }

                if ('' === $value) {
                    $value = $defaultData[$field];

                    // 处理特殊时间
                    if ('CURRENT_TIMESTAMP' === $value) {
                        $value = date('Y-m-d H:i:s');
                    }
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
        check_entity_class($entityClass);

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

if (!function_exists('check_entity_class')) {
    /**
     * 判断是否为实体类.
     */
    function check_entity_class(string $entityClass): void
    {
        if (!is_subclass_of($entityClass, \Leevel\Database\Ddd\Entity::class)) {
            throw new \Exception(sprintf('Entity class %s is invalid.', $entityClass));
        }
    }
}

if (!function_exists('get_date_rand')) {
    /**
     * 获取时间随机码.
     */
    function get_date_rand(bool $nextSequence = false): string
    {
        $time = date('YmdHis');
        $microTime = substr(explode(' ', microtime())[0], 2, 2);
        $currentTime = $time.$microTime;
        if (!$nextSequence) {
            return $currentTime;
        }

        /** @var \Godruoyi\Snowflake\RedisSequenceResolver $redisSequence */
        $redisSequence = \App::make('redis_sequence');
        $nextSequence = $redisSequence->sequence((int) $currentTime);

        return $currentTime.($nextSequence ?: '');
    }
}

if (!function_exists('snowflake')) {
    /**
     * 获取雪花算法唯一键.
     */
    function snowflake(): int
    {
        /** @var \Godruoyi\Snowflake\Snowflake $snowflake */
        $snowflake = \App::make('snowflake');

        return (int) $snowflake->id();
    }
}

if (!function_exists('generate_document')) {
    /**
     * 获取编号.
     */
    function generate_document(array $config = [], Closure $sourceNext = null): string
    {
        return (new GenerateDocument($config))->handle($sourceNext);
    }
}

if (!function_exists('switch_database')) {
    /**
     * 切换数据库.
     */
    function switch_database(int $platformId, int $companyId): void
    {
        // 注册平台到容器
        $platformDbAndTable = PlatformCompany::getPlatformDbAndTable($platformId);
        \App::instance('platform_id', $platformId);
        \App::container()->instance('platform_db', $platformDbAndTable['db']);
        \App::container()->instance('platform_table', $platformDbAndTable['table']);

        // 注册公司到容器
        $companyDbAndTable = PlatformCompany::getCompanyDbAndTable($companyId);
        \App::instance('company_id', $companyId);
        \App::container()->instance('company_db', $companyDbAndTable['db']);
        \App::container()->instance('company_table', $companyDbAndTable['table']);

        // 设置平台和公司连接
        PlatformCompany::setPlatformCompanyConnect(
            $platformDbAndTable['db'],
            $companyDbAndTable['db'],
            (string) Leevel::env('DATABASE_NAME_PREFIX', ''),
            (string) Leevel::env('DATABASE_COMMON_NAME_PREFIX', ''),
        );
    }
}

if (!function_exists('get_platform_company_entity_table')) {
    /**
     * 获取平台公司实体分表名字.
     *
     * - 表数据量非常大，按照平台和公司同时分表
     */
    function get_platform_company_entity_table(string $table): string
    {
        $platformTable = (int) \App::make('platform_table');
        $companyTable = (int) \App::make('company_table');

        return ($platformTable ? 'plat'.$platformTable.'_' : '').$table.($companyTable ?: '');
    }
}

if (!function_exists('get_company_entity_table')) {
    /**
     * 获取公司实体分表名字.
     *
     * - 不区分平台，仅仅按照公司分表
     */
    function get_company_entity_table(string $table): string
    {
        $companyTable = (int) \App::make('company_table');

        return $table.($companyTable ?: '');
    }
}

if (!function_exists('get_platform_entity_table')) {
    /**
     * 获取平台实体分表名字.
     *
     * - 不区分公司，仅仅按照平台分表
     */
    function get_platform_entity_table(string $table): string
    {
        $platformTable = (int) \App::make('platform_table');

        return ($platformTable ? 'plat'.$platformTable.'_' : '').$table;
    }
}

if (!function_exists('inject_snowflake_id')) {
    /**
     * 注入雪花算法主键.
     */
    function inject_snowflake_id(array $data, string $entityClass): array
    {
        return batch_inject_snowflake_id([$data], $entityClass)[0];
    }
}

if (!function_exists('batch_inject_snowflake_id')) {
    /**
     * 批量注入雪花算法主键.
     */
    function batch_inject_snowflake_id(array $data, string $entityClass): array
    {
        $shouldInjectId = true;
        $singlePrimaryKey = null;
        check_entity_class($entityClass);

        try {
            if (1 !== count($entityClass::primaryKey())) {
                $shouldInjectId = false;
            } else {
                $singlePrimaryKey = $entityClass::primaryKey()[0];
            }
        } catch (\Throwable) {
            $shouldInjectId = false;
            $singlePrimaryKey = null;
        }

        if (!$shouldInjectId) {
            return $data;
        }

        foreach ($data as &$v) {
            if (!isset($v[$singlePrimaryKey])) {
                $v[$singlePrimaryKey] = snowflake();
            }
        }

        return $data;
    }
}

if (!function_exists('debug')) {
    /**
     * 数据调试 (仅调试使用，合并代码请删除调用).
     */
    function debug(mixed $data, string $debugTag = '', bool $varDumpPattern = false, string $endSeparation = PHP_EOL): void
    {
        /** @phpstan-ignore-next-line */
        $request = http_request();
        // @phpstan-ignore-next-line
        if ($debugTag && $request->get('debug') !== md5($debugTag)) {
            return;
        }

        $backtrace = debug_backtrace();

        // debug_die 调用位置信息
        if (isset($backtrace[1])
            && 'debug_die' === $backtrace[1]['function']
            && !isset($backtrace[1]['class'])) {
            $callInfo = $backtrace[1];
            $callClassInfo = $backtrace[2] ?? null;
        } else {
            // debug 调用位置信息
            $callInfo = $backtrace[0];
            $callClassInfo = $backtrace[1] ?? null;
        }

        // 调试信息
        $debugInfo = [];
        if (isset($callClassInfo)) {
            if (isset($callClassInfo['file'], $callClassInfo['line'])) {
                // @phpstan-ignore-next-line
                $debugInfo['line'] = '['.$callClassInfo['file'].':'.$callClassInfo['line'].']';
            }
            // @phpstan-ignore-next-line
            if (isset($callClassInfo['class'])) {
                // @phpstan-ignore-next-line
                $debugInfo['class'] = '\\'.$callClassInfo['class'].'::'.$callClassInfo['function'].'()';
            } else {
                // @phpstan-ignore-next-line
                $debugInfo['function'] = $callClassInfo['function'];
            }
        }
        // @phpstan-ignore-next-line
        $debugInfo['debug'] = '['.$callInfo['file'].':'.$callInfo['line'].']';
        $debugInfo['data'] = $data;

        $varDumpPattern ? var_dump($debugInfo) : print_r($debugInfo);
        print_r($endSeparation);
    }
}

if (!function_exists('get_field_data')) {
    /**
     * 获取字段数据.
     */
    function get_field_data(array $data, string $field): array
    {
        return array_values(array_unique(array_column($data, $field)));
    }
}

if (!function_exists('api_ql_batch')) {
    /**
     * API批量查询语言.
     *
     * @todo 内部调用不走接口权限
     */
    function api_ql_batch(array $apis, array $params, bool $withoutDebug = true): array
    {
        /** @phpstan-ignore-next-line */
        $currentRequest = http_request();
        $request = new Request();
        $request->query->add([
            'apis' => $apis,
            'params' => $params,
            'token' => $currentRequest->get('token'),
        ]);

        // 关闭调试
        $closeDebug = $withoutDebug && \Leevel::isDebug();
        if ($closeDebug) {
            Config::set('debug', false);
        }

        $batchParams = new ApiQLBatchParams($request->all());

        /** @phpstan-ignore-next-line */
        $response = (new ApiQLBatch())->handle($batchParams, $request);
        if ($response instanceof JsonResponse) {
            $data = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
            if (!is_array($data)) {
                throw new BusinessException(ErrorCode::ID2023051617254261);
            }
        } else {
            $data = ['content' => $response->getContent()];
        }

        // 恢复调试
        if ($closeDebug) {
            Config::set('debug', true);
        }

        return $data;
    }
}

if (!function_exists('response_add_cors_headers')) {
    function response_add_cors_headers(Response $response): Response
    {
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
            // UniApp 开源项目添加 Platform 头部
            'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept, token, Platform',
            'Access-Control-Allow-Credentials' => 'true',
        ];
        $response->headers->add($headers);

        return $response;
    }
}

if (!function_exists('get_entity_class_name')) {
    function get_entity_class_name(string $entityClass): string
    {
        $entityClass = substr($entityClass, 4);
        $entityClass = str_replace('\\Entity\\', '\\', $entityClass);
        $entityClass = str_replace('\\', ':', $entityClass);

        return UnCamelize::handle($entityClass);
    }
}

if (!function_exists('api_ql')) {
    /**
     * API查询语言.
     */
    function api_ql(string $entity, array $input, bool $parseEntity = true, string $type = 'list_only'): array
    {
        $input['entity_class'] = $parseEntity ? get_entity_class_name($entity) : $entity;
        $inputWhere = ReadParams::exceptInput($input);
        if (isset($input['where'])) {
            $inputWhere = array_merge($inputWhere, $input['where']);
        }
        $input['where'] = $inputWhere;
        $params = new ApiQLParams($input);

        if ('list_only' === $type) {
            $params->listOnly = true;
        } elseif ('list_page' === $type) {
            $params->listPage = true;
        }

        $w = new UnitOfWork();
        $service = new ApiQL($w);

        return $service->handle($params);
    }
}

if (!function_exists('api_ql_list_only')) {
    /**
     * API查询语言列表（只查询列表）.
     */
    function api_ql_list_only(string $entity, array $input, bool $parseEntity = true): array
    {
        return api_ql($entity, $input, $parseEntity);
    }
}

if (!function_exists('api_ql_list_page')) {
    /**
     * API查询语言列表查询某页数据（不查询总记录）.
     */
    function api_ql_list_page(string $entity, array $input, bool $parseEntity = true): array
    {
        return api_ql($entity, $input, $parseEntity, 'list_page');
    }
}

if (!function_exists('api_ql_store')) {
    /**
     * API查询语言保存.
     */
    function api_ql_store(string $entity, array $input, bool $parseEntity = true): Entity
    {
        $w = new UnitOfWork();
        $service = new ApiQLStore($w);
        $input['entity_class'] = $parseEntity ? get_entity_class_name($entity) : $entity;
        $inputEntity = ApiQLStoreParams::exceptInput($input);
        $input['entity_data'] = $inputEntity;
        $params = new ApiQLStoreParams($input);

        return $service->handle($params);
    }
}

if (!function_exists('api_ql_update')) {
    /**
     * API查询语言更新.
     */
    function api_ql_update(string $entity, int $id, array $input, string $validatorScene = 'update', bool $parseEntity = true): Entity
    {
        $w = new UnitOfWork();
        $service = new ApiQLUpdate($w);
        $input['entity_class'] = $parseEntity ? get_entity_class_name($entity) : $entity;
        $input['id'] = $id;
        $inputEntity = ApiQLUpdateParams::exceptInput($input);
        $input['entity_data'] = $inputEntity;
        $params = new ApiQLUpdateParams($input);
        $params->validatorScene = $validatorScene;

        return $service->handle($params);
    }
}

if (!function_exists('api_ql_prepare')) {
    /**
     * API查询通用预处理.
     *
     * - 原本可以通过关联模型一次性查询数据
     * - 如果已经获得原数据，可以快速解决表数据IN查询
     */
    function api_ql_prepare(
        array $data,
        string $entity,
        string $sourceKey,
        string $targetKey,
        array $fields,
        string $prefix = '',
        bool $keepColumns = true,
        array $condition = [],
        bool $parseEntity = true
    ): array {
        if (!$data) {
            return $data;
        }

        $result = [];
        $targetData = array_values(array_filter(array_column($data, $sourceKey)));
        $sourceFields = $fields;
        if ($targetData) {
            $fields[] = $targetKey;
            $result = api_ql_list_only($entity, array_merge($condition, [
                'column' => array_values($fields),
                $targetKey => [
                    'in' => $targetData,
                ],
            ]), $parseEntity);
            if (!empty($result['data'])) {
                $result = array_column($result['data'], null, $targetKey);
            } else {
                $result = [];
            }
        }

        foreach ($data as &$v) {
            $itemData = [];
            $targetItem = [];
            if (isset($result[$v[$sourceKey]])) {
                $targetItem = $result[$v[$sourceKey]];
            }

            foreach ($sourceFields as $alias => $field) {
                $alias = is_string($alias) ? $alias : $field;
                if (isset($targetItem[$field])) {
                    $itemData[$prefix.$alias] = $targetItem[$field];
                } else {
                    $itemData[$prefix.$alias] = $v[$prefix.$alias] ?? null;
                }
            }

            if ($keepColumns) {
                $v = array_merge($v, $itemData);
            } else {
                $v[$prefix] = $itemData;
            }
        }

        return $data;
    }
}
