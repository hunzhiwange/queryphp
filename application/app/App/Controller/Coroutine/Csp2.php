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
 * 协程：Go + Chan + Defer.
 *
 * @see https://wiki.swoole.com/wiki/page/p-csp.html
 * @codeCoverageIgnore
 */
class Csp2
{
    /**
     * 改变顺序.
     */
    public function handle(): string
    {
        $this->message('Start');

        go(function () {
            $this->test1();
        });
        go(function () {
            $this->test2();
        });

        $this->message('Done');

        return 'Done';
    }

    private function test1(): void
    {
        sleep(1);
        $this->message('b');
    }

    private function test2(): void
    {
        sleep(2);
        $this->message('c');
    }

    /**
     * 输出消息.
     */
    private function message(string $message): void
    {
        dump(func(fn () => message_with_time($message)));
    }
}
