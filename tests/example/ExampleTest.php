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

use queryyetsimple\bootstrap\testing\testcase;

/**
 * 继承框架基础示例.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
class ExampleTest extends testcase
{
    /**
     * 基本测试.
     */
    public function testBase()
    {
        $this->assertEquals('QueryPHP', 'QueryPHP');
    }
}
