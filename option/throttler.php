<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
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
     * 这里可以可以设置为 file_throttler、redis_throttler 等
     * 这里使用的缓存组件的中的配置
     * 系统为所有缓存提供了统一的接口，在使用上拥有一致性
     */
    'driver' => Leevel::env('THROTTLER_DRIVER', 'file_throttler'),
];
