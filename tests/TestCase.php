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

namespace Tests;

use Leevel\Leevel\Testing\Database;
use Leevel\Leevel\Testing\TestCase as TestCases;

/**
 * phpunit 基础测试类.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2017.05.09
 *
 * @version 1.0
 */
abstract class TestCase extends TestCases
{
    use Helper;
    use App;
    use Database;
}
