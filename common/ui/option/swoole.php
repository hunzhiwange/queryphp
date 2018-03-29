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
        'port' => '9501', 

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

        // 设置启动的 task worker 进程数
        // https://wiki.swoole.com/wiki/page/276.html
        'task_worker_num' => 4,
    
        // swoole 进程名称
        'process_name' => 'queryphp.swoole.websocket', 
        
        // swoole 进程保存路径
        'pid_path' => path_swoole_cache('pid') . '/websocket.pid'
    ]
];
