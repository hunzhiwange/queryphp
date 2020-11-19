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

use Closure;
use function Common\Infra\Helper\message_with_time;
use Exception;
use Throwable;

/**
 * 使用 Swoole 原生定时器工作任务.
 *
 * @codeCoverageIgnore
 */
class Work
{
    /**
     * 执行入口.
     *
     * @throws \Exception
     */
    public function handle(): string
    {
        $this->work(function (): void {
            $this->message('Failed test');

            throw new Exception('Failed test');
        }, 5 * 1000, 5);

        $this->work(function (): void {
            $this->message('Success test');
        }, 5 * 1000, 5);

        return 'Work done';
    }

    /**
     * 执行任务
     */
    private function work(Closure $work, int $perMillisecond, int $maxCount): void
    {
        $count = 0;

        swoole_timer_tick($perMillisecond, function (int $timerId) use ($work, &$count, $perMillisecond, $maxCount) {
            $count++;
            $this->message(sprintf('Work doing at `%d` try', $count));

            try {
                $work();
                swoole_timer_clear($timerId);
                $this->message(sprintf('Work successed at `%d` try', $count));
            } catch (Throwable) {
                if ($count >= $maxCount) {
                    swoole_timer_clear($timerId);
                    $this->message(sprintf('Work faield after `%d` tries', $maxCount));
                } else {
                    $this->message(sprintf('Try after `%d` millisecond', $perMillisecond));
                }
            }
        });
    }

    /**
     * 输出消息.
     */
    private function message(string $message): void
    {
        dump(func(fn () => message_with_time($message)));
    }
}
