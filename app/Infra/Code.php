<?php

declare(strict_types=1);

namespace App\Infra;

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
        Cache::set('captcha:'.$id, $code);
    }

    /**
     * 获取验证码.
     */
    public function get(string $id): string
    {
        // @phpstan-ignore-next-line
        return Cache::get('captcha:'.$id) ?: '';
    }
}
