<?php

declare(strict_types=1);

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
