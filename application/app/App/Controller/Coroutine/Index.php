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
 * 协程.
 *
 * @see https://www.jianshu.com/p/745b0b3ffae7
 * @codeCoverageIgnore
 */
class Index
{
    /**
     * 没有 IO 阻塞依次执行.
     */
    public function handle(): string
    {
        $this->message('Start coroutine');

        go(function () {
            $this->message('1');
        });

        $this->message('2');

        go(function () {
            $this->message('3');
        });

        return 'Coroutine done';
    }

    /**
     * 输出消息.
     */
    private function message(string $message): void
    {
        dump(func(fn () => message_with_time($message)));
    }
}
