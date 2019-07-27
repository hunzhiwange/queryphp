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

namespace App\App\Controller\Coroutine;

use Common\Infra\Helper\message_with_time;

/**
 * 协程：实现 Go 语言风格的 defer.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.07.27
 *
 * @version 1.0
 *
 * @see https://wiki.swoole.com/wiki/page/p-go_defer.html
 */
class Defer
{
    /**
     * 改变顺序.
     *
     * - 函数结束时，对象自动析构，defer 任务自动执行
     *
     * @return string
     */
    public function handle(): string
    {
        $this->message('Start');

        $o = new DeferTask();

        // 逻辑代码
        $o->add(function () {
            //code 1
            $this->message('code 1');
        });
        $o->add(function () {
            //code 2
            $this->message('code 2');
        });

        $this->message('Done');

        return 'Done';
    }

    /**
     * 输出消息.
     *
     * @param string $message
     */
    private function message(string $message): void
    {
        dump(f(message_with_time::class, $message));
    }
}

class DeferTask
{
    /**
     * 任务.
     *
     * @var callable[]
     */
    private $tasks;

    /**
     * 析构函数.
     */
    public function __destruct()
    {
        $tasks = array_reverse($this->tasks);

        foreach ($tasks as $fn) {
            $fn();
        }
    }

    /**
     * 添加任务.
     *
     * @param callable $fn
     */
    public function add(callable $fn): void
    {
        $this->tasks[] = $fn;
    }
}
