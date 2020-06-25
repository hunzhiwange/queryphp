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

namespace App\App\Controller\Timer;

use function Common\Infra\Helper\message_with_time;

/**
 * 使用 Swoole 原生每隔一段时间执行同一任务.
 *
 * @codeCoverageIgnore
 */
class Index
{
    /**
     * 执行入口.
     */
    public function handle(): string
    {
        $this->message('Start timer');

        // 每隔 1 秒触发一次
        $n = 1;
        $timerId = swoole_timer_tick(1000, function () use (&$n) {
            $this->message(sprintf('Try `%d`', $n));
            $n++;
        });

        $this->message(sprintf('Timer id is `%d`', $timerId));

        // 运行 3 秒后删除定时器
        swoole_timer_after(3000, function () use ($timerId) {
            $this->message('Clear timer');
            swoole_timer_clear($timerId);
        });

        return 'Timer done';
    }

    /**
     * 输出消息.
     */
    private function message(string $message): void
    {
        dump(func(fn () => message_with_time($message)));
    }
}
