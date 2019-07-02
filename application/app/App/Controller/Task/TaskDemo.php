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

namespace App\App\Controller\Task;

use Swoole\Server as SwooleServer;

/**
 * 演示任务.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.07.02
 *
 * @version 1.0
 */
class TaskDemo
{
    /**
     * 响应.
     *
     * @param int            $arg1
     * @param int            $arg2
     * @param \Swoole\Server $server
     * @param int            $taskId
     * @param int            $fromId
     */
    public function handle(int $arg1, int $arg2, SwooleServer $server, int $taskId, int $fromId): void
    {
        dump('Demo task start.');
        dump(4 === $arg1);
        dump(5 === $arg2);
        dump('Demo task end.');
    }
}
