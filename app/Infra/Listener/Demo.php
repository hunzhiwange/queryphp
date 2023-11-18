<?php

declare(strict_types=1);

namespace App\Infra\Listener;

class Demo extends Listener
{
    /**
     * 构造函数.
     *
     * - 支持依赖注入.
     */
    public function __construct()
    {
    }

    /**
     * 监听器响应.
     */
    public function handle(): void
    {
        $args = \func_get_args();
        $event = array_shift($args);
        print_r($event);
        print_r($args);
    }
}
