<?php

declare(strict_types=1);

use App\Infra\Module\RoadRunner\RoadRunnerDump;
use App\Infra\Proxy\Permission;
use Leevel\Cache\Manager;
use Leevel\Cache\Redis;
use Leevel\Database\IDatabase;
use Leevel\Di\Container;
use Leevel\Http\Request;
use Leevel\Support\Arr\Only;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('enabledCoroutine')) {
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

if (!function_exists('redis_cache')) {
    /**
     * 获取 redis.
     */
    function redis_cache(): \Redis
    {
        /** @var Manager $manager */
        $manager = \App::make('caches');

        /** @var Redis $phpRedis */
        $phpRedis = $manager->connect('redis');

        // @phpstan-ignore-next-line
        return $phpRedis->getHandle();
    }
}
