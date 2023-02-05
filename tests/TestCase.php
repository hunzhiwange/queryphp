<?php

declare(strict_types=1);

namespace Tests;

use Leevel\Kernel\Testing\Database;
use Leevel\Kernel\Testing\TestCase as TestCases;

/**
 * phpunit 基础测试类.
 */
abstract class TestCase extends TestCases
{
    use App;
    use Database;
    use Helper;
}
