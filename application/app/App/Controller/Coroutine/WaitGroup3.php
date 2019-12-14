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
use Swoole\Coroutine\WaitGroup;

/**
 * 协程：实现 sync.WaitGroup 功能.
 *
 * - Swoole 新版本自带 WaitGroup
 *
 * @see https://wiki.swoole.com/wiki/page/p-waitgroup.html
 * @see https://github.com/swoole/swoole-src/blob/master/library/core/Coroutine/WaitGroup.php
 * @codeCoverageIgnore
 */
class WaitGroup3
{
    /**
     * 改变顺序.
     */
    public function handle(): string
    {
        $this->message('Start');

        go(function () {
            $result = [];
            $time = time();
            $wg = new WaitGroup();

            $wg->add();
            go(function () use ($wg, &$result) {
                $result['k1'] = 'coroutine 1';
                sleep(1);
                $wg->done();
            });

            $wg->add();
            go(function () use ($wg, &$result) {
                $result['k2'] = 'coroutine 2';
                sleep(2);
                $wg->done();
            });

            $wg->wait();

            foreach ($result as $k => $v) {
                $this->message($k);
                $this->message($v);
            }

            $this->message('Time: '.(time() - $time));
        });

        $this->message('Done');

        return 'Done';
    }

    /**
     * 输出消息.
     */
    private function message(string $message): void
    {
        dump(f(message_with_time::class, $message));
    }
}
