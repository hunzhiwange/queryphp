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

use Co;
use Common\Infra\Helper\message_with_time;

/**
 * 协程.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.07.04
 *
 * @version 1.0
 *
 * @see https://www.jianshu.com/p/745b0b3ffae7
 */
class Demo4
{
    /**
     * 多个协程性能提升.
     *
     * @return string
     */
    public function handle(): string
    {
        $this->message('Start coroutine');

        $n = 10;
        for ($i = 0; $i < $n; $i++) {
            sleep(1);
            $this->message(microtime(true).": normal {$i}");
        }
        $this->message('Normal end');

        $n = 10;
        for ($i = 0; $i < $n; $i++) {
            go(function () use ($i) {
                Co::sleep(1);
                $this->message(microtime(true).": coroutine {$i}");
            });
        }
        $this->message('Coroutine end');

        return 'Coroutine done';
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
