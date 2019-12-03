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
 * 协程：Go + Chan + Defer.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.07.26
 *
 * @version 1.0
 *
 * @see https://wiki.swoole.com/wiki/page/p-csp.html
 * @codeCoverageIgnore
 */
class Csp
{
    /**
     * 改变顺序.
     */
    public function handle(): string
    {
        $this->message('Start');

        $this->test1();
        $this->test2();

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
        dump(f(message_with_time::class, $message));
    }
}
