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

namespace App\App\Controller\Api;

use Leevel\Pool as Pools;
use Leevel\Protocol\TPool;

/**
 * pool tests.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.12.17
 *
 * @version 1.0
 */
class Pool
{
    /**
     * 默认方法.
     *
     * @return array
     */
    public function handle()
    {
        $obj = Pools::get(TestObjForPool::class, 'hello', 'world');

        $result = $obj->handle();

        unset($obj);

        $obj = Pools::get(TestObjForPool::class, 'yes', 'no');

        $result .= '<br /> VS <br />'.$obj->handle();

        return $result;
    }
}

class TestObjForPool
{
    use TPool;

    /**
     * 属性 foo.
     *
     * @var string
     */
    private $foo;

    /**
     * 属性 bar.
     *
     * @var string
     */
    private $bar;

    /**
     * 属性 more.
     *
     * @var string
     */
    private $more;

    /**
     * 构造函数.
     *
     * @param string $a
     * @param string $b
     */
    public function __construct(string $a, string $b)
    {
        $this->foo = $a;
        $this->bar = $b;
    }

    /**
     * 响应句柄.
     *
     * @return string
     */
    public function handle(): string
    {
        return sprintf('foo: %s;bar: %s;more: %s;', $this->foo, $this->bar, $this->more);
    }

    /**
     * 垃圾回收前清理.
     * 清理后返还给对象池以便于复用.
     */
    private function destruct()
    {
        $this->more = 'destruct';
    }
}
