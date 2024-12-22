<?php

declare(strict_types=1);

namespace App\Infra\Proxy;

use App\Infra\Service\Demo as DemoService;

/**
 * 代理 Demo.
 */
class Demo
{
    /**
     * call.
     *
     * @return mixed
     */
    public static function __callStatic(string $method, array $args)
    {
        return self::proxy()->{$method}(...$args);
    }

    /**
     * 代理服务.
     */
    public static function proxy(): DemoService
    {
        return new DemoService();
    }
}
