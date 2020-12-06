<?php

declare(strict_types=1);

namespace Admin\Infra;

use Leevel\Cache\Proxy\Cache;

/**
 * 验证码存储.
 */
class Code
{
    /**
     * 设置验证码.
     */
    public function set(string $id, string $code): void
    {
        Cache::set('seccode:admin:'.$id, $code);
    }

    /**
     * 获取验证码.
     */
    public function get(string $id): string
    {
        return Cache::get('seccode:admin:'.$id) ?: '';
    }
}
