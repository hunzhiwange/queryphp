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
use Swoole\Runtime;

/**
 * 协程：并发 shell_exec.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.07.27
 *
 * @version 1.0
 *
 * @see https://wiki.swoole.com/wiki/page/1017.html
 * @codeCoverageIgnore
 */
class Shell2
{
    /**
     * 改变顺序.
     *
     * @return string
     */
    public function handle(): string
    {
        Runtime::enableCoroutine(false);

        $this->message('Start');

        $c = 10;
        while ($c--) {
            go(function () use ($c) {
                // 这里使用 sleep 5 来模拟一个很长的命令
                shell_exec('sleep 5');
                $this->message('exec '.$c);
            });
        }

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
