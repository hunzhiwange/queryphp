<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    /*
     * ---------------------------------------------------------------
     * 请求频率缓存驱动
     * ---------------------------------------------------------------
     *
     * 这里可以可以设置为 file、memcache 等
     * 这里使用的缓存组件的中的配置
     * 系统为所有缓存提供了统一的接口，在使用上拥有一致性
     */
    'driver' => Leevel::env('throttler_driver', 'file'),
];
