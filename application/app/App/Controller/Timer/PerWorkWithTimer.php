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

use Common\Infra\Helper\message_with_time;
use Leevel\Protocol\ITimer;

/**
 * 每隔一段时间执行同一任务.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.07.03
 *
 * @version 1.0
 */
class PerWorkWithTimer
{
    /**
     * 执行入口.
     *
     * @param \Leevel\Protocol\ITimer $timer
     *
     * @return string
     */
    public function handle(ITimer $timer): string
    {
        $this->message('Start timer');

        $timer->perWork(function (int $count): void {
            $this->message(sprintf('Try `%d`', $count));
        }, 1000, 3);

        return 'Timer done';
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
