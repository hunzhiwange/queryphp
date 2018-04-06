<?php
// (c) 2018 http://your.domain.com All rights reserved.


/**
 * swoole 默认配置文件
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.21
 * @version 1.0
 */
return [

    /**
     * ---------------------------------------------------------------
     * 默认 swoole 服务驱动
     * ---------------------------------------------------------------
     *
     * swoole 服务类型，支持 default,http,websocket
     * see https://wiki.swoole.com/wiki/page/p-server.html
     */
    'default' => env('swoole_server', 'http'),

    /**
     * ---------------------------------------------------------------
     * 默认 swoole 服务更新延迟时间
     * ---------------------------------------------------------------
     *
     * swoole 服务更新延迟时间，单位为秒
     */
    'autoreload_after_seconds' => 10,

    /**
     * ---------------------------------------------------------------
     * 默认 swoole 源代码监听目录
     * ---------------------------------------------------------------
     *
     * 使用 inotify 监听 PHP 源码默认目录
     * 程序文件更新时自动重启 swoole 服务端
     */
    'autoreload_watch_dir' => [
        app()->pathApplication(),
        app()->pathCommon()
    ],
    
    /**
     * ---------------------------------------------------------------
     * swoole server
     * ---------------------------------------------------------------
     *
     * swoole 基础服务器配置参数
     * see https://wiki.swoole.com/wiki/page/274.html
     * see https://wiki.swoole.com/wiki/page/p-server.html
     */
    'server' => [
        // 监听 IP 地址
        // see https://wiki.swoole.com/wiki/page/p-server.html
        // see https://wiki.swoole.com/wiki/page/327.html
        'host' => '127.0.0.1', 
        
        // 监听端口
        // see https://wiki.swoole.com/wiki/page/p-server.html
        // see https://wiki.swoole.com/wiki/page/327.html
        'port' => '9500', 

        // 设置启动的 worker 进程数
        // see https://wiki.swoole.com/wiki/page/275.html
        'worker_num' => 8, 
        
        // 守护进程化
        // see https://wiki.swoole.com/wiki/page/278.html
        'daemonize' => 0,

        // 设置启动的 task worker 进程数
        // https://wiki.swoole.com/wiki/page/276.html
        'task_worker_num' => 4,

        // swoole 进程名称
        'process_name' => 'queryphp.swoole.default', 
        
        // swoole 进程保存路径
        'pid_path' => path_swoole_cache('pid') . '/default.pid',
    ], 
    
    /**
     * ---------------------------------------------------------------
     * swoole http server
     * ---------------------------------------------------------------
     *
     * swoole http 服务器配置参数
     * https://wiki.swoole.com/wiki/page/274.html
     * https://wiki.swoole.com/wiki/page/620.html
     */
    'http_server' => [
        // 监听端口
        // see https://wiki.swoole.com/wiki/page/p-server.html
        // see https://wiki.swoole.com/wiki/page/327.html
        'port' => '9501', 

        // swoole 进程名称
        'process_name' => 'queryphp.swoole.http', 
        
        // swoole 进程保存路径
        'pid_path' => path_swoole_cache('pid') . '/http.pid'
    ],

    /**
     * ---------------------------------------------------------------
     * swoole websocket server
     * ---------------------------------------------------------------
     *
     * swoole websocket 服务器配置参数
     * https://wiki.swoole.com/wiki/page/274.html
     * https://wiki.swoole.com/wiki/page/620.html
     * https://wiki.swoole.com/wiki/page/397.html
     */
    'websocket_server' => [
        // 监听 IP 地址
        // see https://wiki.swoole.com/wiki/page/p-server.html
        // see https://wiki.swoole.com/wiki/page/327.html
        'host' => '0.0.0.0', 

        // 监听端口
        // see https://wiki.swoole.com/wiki/page/p-server.html
        // see https://wiki.swoole.com/wiki/page/327.html
        'port' => '9502', 

        // 设置启动的 task worker 进程数
        // https://wiki.swoole.com/wiki/page/276.html
        'task_worker_num' => 4,
    
        // swoole 进程名称
        'process_name' => 'queryphp.swoole.websocket', 
        
        // swoole 进程保存路径
        'pid_path' => path_swoole_cache('pid') . '/websocket.pid'
    ],

    /**
     * ---------------------------------------------------------------
     * swoole rpc server
     * ---------------------------------------------------------------
     *
     * swoole rpc 服务器配置参数
     * 底层基于 thrift 跨语言编程框架
     * http://thrift.apache.org/    
     * 定义的 thrift 结构见 src/Queryyetsimple/Protocol/Thrift/Struct/queryphp.thrift
     */
    'rpc_server' => [
        // 监听 IP 地址
        // see https://wiki.swoole.com/wiki/page/p-server.html
        // see https://wiki.swoole.com/wiki/page/327.html
        'host' => '127.0.0.1', 

        // 监听端口
        // see https://wiki.swoole.com/wiki/page/p-server.html
        // see https://wiki.swoole.com/wiki/page/327.html
        'port' => '1355', 

        // 设置启动的 task worker 进程数
        // https://wiki.swoole.com/wiki/page/276.html
        'task_worker_num' => 4,

        // 数据包分发策略
        // 1：收到会轮询分配给每一个 worker 进程
		// 3：抢占模式，系统会根据 worker 进程的闲置状态，只会投递给闲置的 worker 进程
		// https://wiki.swoole.com/wiki/page/277.html  
        'dispatch_mode' => 1,

        // 打开包长检测
        // 包体长度检测提供了固定包头和包体这种协议格式的检测。
        // 启用后可以保证 worker 进程 onReceive 每一次都收到完整的包
        // https://wiki.swoole.com/wiki/page/287.html
        'open_length_check' => true,
        
        // 最大请求包长度，8M 
        // https://wiki.swoole.com/wiki/page/301.html
        'package_max_length' => 8192000,
        
        // 长度的类型,参见 PHP 的 pack 函数
        // http://php.net/manual/zh/function.pack.php
        // https://wiki.swoole.com/wiki/page/463.html
        'package_length_type' => 'N',

        // 第 N 个字节是包长度的值
        // 如果未 0，表示整个包，包含包体和包头
        // https://wiki.swoole.com/wiki/page/287.html
        'package_length_offset' => 0, 

        // 从第几个字节计算长度
        // https://wiki.swoole.com/wiki/page/287.html
        'package_body_offset' => 4,

        // swoole 进程名称
        'process_name' => 'queryphp.swoole.rpc', 
        
        // swoole 进程保存路径
        'pid_path' => path_swoole_cache('pid') . 'rpc.pid'
    ]
];
