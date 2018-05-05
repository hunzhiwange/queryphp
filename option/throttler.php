<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.

/**
 * 请求频率默认配置文件
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.08.07
 * @version 1.0
 */
return [

    /**
     * ---------------------------------------------------------------
     * 请求频率缓存驱动
     * ---------------------------------------------------------------
     *
     * 这里可以可以设置为 file、memcache 等
     * 这里使用的缓存组件的中的配置
     * 系统为所有缓存提供了统一的接口，在使用上拥有一致性
     */
    'driver' => env('throttler_driver', null)
];
