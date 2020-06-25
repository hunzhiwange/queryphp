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

use function Common\Infra\Helper\message_with_time;

/**
 * 协程：实现 Go 语言风格的 defer.
 *
 * @see https://wiki.swoole.com/wiki/page/p-go_defer.html
 * @codeCoverageIgnore
 */
class Defer
{
    /**
     * 改变顺序.
     *
     * - 函数结束时，对象自动析构，defer 任务自动执行
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
     */
    private function message(string $message): void
    {
        dump(func(fn () => message_with_time($message)));
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
     */
    public function add(callable $fn): void
    {
        $this->tasks[] = $fn;
    }
}
