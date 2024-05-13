<?php

declare(strict_types=1);
use Leevel\Server\Http;
use Leevel\Server\Process\HotOverload;
use Leevel\Server\Process\MaxRequest;
use Leevel\Server\Websocket;

return [
    /*
     * ---------------------------------------------------------------
     * 默认服务驱动
     * ---------------------------------------------------------------
     *
     * 系统为所有服务提供了统一的接口，在使用上拥有一致性
     */
    'default' => Leevel::env('SERVER_DRIVER', 'http'),

    /*
     * ---------------------------------------------------------------
     * 设置启动的 worker 进程数
     * ---------------------------------------------------------------
     *
     * 可以启动CPU核心数量数，充分利用多核
     * 开发阶段可以只启动一个即可
     */
    'worker_num' => (int) Leevel::env('SERVER_WORKER_NUM', 1),

    /*
     * ---------------------------------------------------------------
     * PHP 内置服务器
     * ---------------------------------------------------------------
     *
     * 仅可用于开发环境，不可用于生产
     */
    'build_in_port' => (int) Leevel::env('SERVER_BUILD_IN_PORT', 9527),

    /*
     * ---------------------------------------------------------------
     * 自定义进程
     * ---------------------------------------------------------------
     *
     * 可以启动CPU核心数量数，充分利用多核
     */
    'custom_process' => [
        HotOverload::class => [
            // 是否启用
            'enabled' => Leevel::env('SERVER_CUSTOM_PROCESS_HOT_OVERLOAD_ENABLED', false),

            // 默认服务延迟重启计数器
            'delay_count' => (int) Leevel::env('SERVER_CUSTOM_PROCESS_HOT_OVERLOAD_DELAY_COUNT', 0),

            // 默认检测间隔时间
            // Swoole 检测间隔时间，单位为毫秒
            'time_interval' => (int) Leevel::env('SERVER_CUSTOM_PROCESS_HOT_OVERLOAD_TIME_INTERVAL', 20),

            // 默认源代码监听目录
            // 使用 HotOverload 监听 PHP 源码默认目录
            // 程序文件更新时自动重启 Swoole 服务端
            'hot_overload_watch' => [
                Leevel::appPath('app'),
                Leevel::configPath(),
                Leevel::storagePath('bootstrap'),
            ],
        ],
        MaxRequest::class => [
            // 是否启用
            'enabled' => Leevel::env('SERVER_CUSTOM_PROCESS_MAX_REQUEST_ENABLED', true),

            // 设置 worker 进程的最大任务数
            // 默认值：0 即不会退出进程
            // https://wiki.swoole.com/#/server/setting?id=max_request
            'max_request' => (int) Leevel::env('SERVER_CUSTOM_PROCESS_MAX_REQUEST_MAX_REQUEST', 0),

            // 设置 Worker 进程收到停止服务通知后最大等待时间【默认值：3】
            // https://wiki.swoole.com/#/server/setting?id=max_wait_time
            'max_wait_time' => (int) Leevel::env('SERVER_CUSTOM_PROCESS_MAX_REQUEST_MAX_WAIT_TIME', 3),
        ],
    ],

    /*
     * ---------------------------------------------------------------
     * 服务连接配置
     * ---------------------------------------------------------------
     */
    'connect' => [
        // HTTP 服务器配置参数
        'http' => [
            // driver
            'driver' => 'http',

            // 驱动类
            'driver_class' => Http::class,

            // 监听地址
            'host' => (string) Leevel::env('SERVER_HTTP_HOST', '127.0.0.1'),

            // 监听端口
            'port' => (int) Leevel::env('SERVER_HTTP_PORT', 9527),

            // 进程名称
            'process_name' => 'SERVER.HTTP',

            // 进程保存路径
            'pid_path' => Leevel::storagePath('server/http.pid'),
        ],

        // Websocket 服务器配置参数
        'websocket' => [
            // driver
            'driver' => 'websocket',

            // 驱动类
            'driver_class' => Websocket::class,

            // 监听地址
            'host' => (string) Leevel::env('SERVER_WEBSOCKET_HOST', '127.0.0.1'),

            // 监听端口
            'port' => (int) Leevel::env('SERVER_WEBSOCKET_PORT', 9528),

            // 进程名称
            'process_name' => 'SERVER.WEBSOCKET',

            // 进程保存路径
            'pid_path' => Leevel::storagePath('server/websocket.pid'),
        ],
    ],
];
