<?php

declare(strict_types=1);

return [
    /*
     * ---------------------------------------------------------------
     * 默认 Swoole 服务延迟重启计数器
     * ---------------------------------------------------------------
     *
     * Swoole 服务延迟重启计数器，单位为次
     * 总延迟时间等于 hotoverload_delay_count*hotoverload_time_interval
     */
    'hotoverload_delay_count' => 5,

    /*
     * ---------------------------------------------------------------
     * 默认 Swoole 检测间隔时间
     * ---------------------------------------------------------------
     *
     * Swoole 检测间隔时间，单位为毫秒
     */
    'hotoverload_time_interval' => 20,

    /*
     * ---------------------------------------------------------------
     * 默认 Swoole 源代码监听目录
     * ---------------------------------------------------------------
     *
     * 使用 HotOverload 监听 PHP 源码默认目录
     * 程序文件更新时自动重启 Swoole 服务端
     */
    'hotoverload_watch' => [
        Leevel::appPath(),
        Leevel::commonPath(),
    ],

    /*
     * ---------------------------------------------------------------
     * Swoole Server
     * ---------------------------------------------------------------
     *
     * Swoole 基础服务器配置参数
     * see https://wiki.swoole.com/wiki/page/274.html
     * see https://wiki.swoole.com/wiki/page/p-server.html
     */
    'server' => [
        // 监听 IP 地址
        // see https://wiki.swoole.com/wiki/page/p-server.html
        // see https://wiki.swoole.com/wiki/page/327.html
        'host' => '0.0.0.0',

        // 监听端口
        // see https://wiki.swoole.com/wiki/page/p-server.html
        // see https://wiki.swoole.com/wiki/page/327.html
        'port' => 9500,

        // 设置启动的 worker 进程数
        // see https://wiki.swoole.com/wiki/page/275.html
        'worker_num' => 8,

        // 守护进程化
        // see https://wiki.swoole.com/wiki/page/278.html
        'daemonize' => 0,

        // 设置启动的 task worker 进程数
        // https://wiki.swoole.com/wiki/page/276.html
        'task_worker_num' => 4,

        // 自定义进程
        'processes' => [],

        // 开发阶段自定义进程
        'processes_dev' => [
            'Leevel\\Protocol\\Process\\HotOverload',
        ],
    ],

    /*
     * ---------------------------------------------------------------
     * Swoole HTTP Server
     * ---------------------------------------------------------------
     *
     * Swoole HTTP 服务器配置参数
     * https://wiki.swoole.com/wiki/page/274.html
     * https://wiki.swoole.com/wiki/page/620.html
     */
    'http' => [
        // 监听端口
        // see https://wiki.swoole.com/wiki/page/p-server.html
        // see https://wiki.swoole.com/wiki/page/327.html
        'port' => 9527,

        // Swoole 进程名称
        'process_name' => 'leevel.http',

        // Swoole 进程保存路径
        'pid_path' => Leevel::runtimePath('protocol/http.pid'),

        // 开启静态路径
        // 配合 Nginx 可以设置这里为 false,nginx 解析静态路径,只将动态路由转发给 Swoole
        'enable_static_handler' => true,

        // 开启静态路径目录
        'document_root' => Leevel::path(),
    ],

    /*
     * ---------------------------------------------------------------
     * Swoole WebSocket Server
     * ---------------------------------------------------------------
     *
     * Swoole websocket 服务器配置参数
     * https://wiki.swoole.com/wiki/page/274.html
     * https://wiki.swoole.com/wiki/page/620.html
     * https://wiki.swoole.com/wiki/page/397.html
     */
    'websocket' => [
        // 监听 IP 地址
        // see https://wiki.swoole.com/wiki/page/p-server.html
        // see https://wiki.swoole.com/wiki/page/327.html
        'host' => '0.0.0.0',

        // 监听端口
        // see https://wiki.swoole.com/wiki/page/p-server.html
        // see https://wiki.swoole.com/wiki/page/327.html
        'port' => 9502,

        // 设置启动的 task worker 进程数
        // https://wiki.swoole.com/wiki/page/276.html
        'task_worker_num' => 4,

        // Swoole 进程名称
        'process_name' => 'leevel.websocket',

        // Swoole 进程保存路径
        'pid_path' => Leevel::runtimePath('protocol/websocket.pid'),
    ],
];
