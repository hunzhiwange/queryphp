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

namespace Common\Domain\Listener;

/**
 * test2 监听器.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.01.29
 *
 * @version 1.0
 */
class Test2 extends Listener
{
    /**
     * 构造函数
     * 支持依赖注入.
     */
    public function __construct()
    {
    }

    /**
     * 监听器响应.
     */
    public function handle()
    {
        echo 'test2';
    }
}
