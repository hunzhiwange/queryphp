<?php
// (c) 2018 http://your.domain.com All rights reserved.

/**
 * 消息队列默认配置文件
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.05.17
 * @version 1.0
 */
return [

    /**
     * ---------------------------------------------------------------
     * 默认消息队列驱动
     * ---------------------------------------------------------------
     *
     * 默认采用 redis 来做消息队列性能比较好
     */
    'default' => env('redis_driver', 'redis'),

    /**
     * ---------------------------------------------------------------
     * 消息队列连接
     * ---------------------------------------------------------------
     *
     * 所有消息队列的连接参数，支持 + 语法合并
     * 如果 redis 设置了认证密码，请加上 password 参数
     */
    '+connect' => [
        // redis 驱动采用 https://github.com/nrk/predis(访问查看详情文档) 作为底层
        // 分别对应 new \Predis\Client($arrServers, $arrOptions) 构造器两个参数
        '+redis' => [
            'servers' => [
                'host' => env('queue_redis_host', '127.0.0.1'),
                'port' => env('queue_redis_port', 6379),
                'password' => env('queue_redis_password', null)
            ],
            'options' => []
        ]
    ]
];
