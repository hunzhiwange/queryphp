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
use Exception;
use Leevel\Protocol\ITimer;

/**
 * 定时器工作任务.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.07.03
 *
 * @version 1.0
 * @codeCoverageIgnore
 */
class WorkWithTimer
{
    /**
     * 执行入口.
     *
     * @throws \Exception
     */
    public function handle(ITimer $timer): string
    {
        $timer->work(function (): void {
            $this->message('Failed test');

            throw new Exception('Failed test');
        }, 1000, 5);

        $timer->work(function (): void {
            $this->message('Success test');
        }, 1000, 5);

        return 'Work done';
    }

    /**
     * 输出消息.
     */
    private function message(string $message): void
    {
        dump(f(message_with_time::class, $message));
    }
}
