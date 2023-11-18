<?php

declare(strict_types=1);

namespace App\Infra\Listener;

class Demo3 extends Listener
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
        echo 'test3';
    }
}
