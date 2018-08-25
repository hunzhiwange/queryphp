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

namespace home\application\job;

class Mails
{
    public function setUp()
    {
        // 这个方法会在perform()之前运行，可以用来做一些初始化工作
        // 如连接数据库、处理参数等
    }

    public function tearDown()
    {
        // 会在perform()之后运行，可以用来做一些清理工作
    }

    public function perform()
    {
        // 执行Job
    }
}
