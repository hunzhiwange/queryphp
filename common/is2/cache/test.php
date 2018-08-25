<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace common\is\cache;

/**
 * 测试缓存.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.20
 *
 * @version 1.0
 */
class test
{
    /**
     * 构造函数.
     */
    public function __construct()
    {
    }

    /**
     * 响应缓存.
     *
     * @return array
     */
    public function handle()
    {
        return [
            'hello',
            'world',
        ];
    }
}
