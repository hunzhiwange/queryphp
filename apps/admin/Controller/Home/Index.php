<?php

declare(strict_types=1);

namespace Admin\Controller\Home;

/**
 * 首页.
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
        return 'hello admin';
    }
}
