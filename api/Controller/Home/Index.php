<?php

declare(strict_types=1);

namespace Api\Controller\Home;

/**
 * 首页.
 *
 * - 通过 http://127.0.0.1:9527/:api 访问此页面
 * - 不建议使用多应用，一套接口为不同的客户端提供服务，一个客户端一个应用标识和应用认证码来实现
 *
 * @codeCoverageIgnore
 */
class Index
{
    /**
     * 默认方法.
     */
    public function handle(): string
    {
        return 'hello api';
    }
}
