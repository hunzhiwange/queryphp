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

use Common\Domain\Task\TaskDemo;
use Common\Infra\Helper\message_with_time;
use Leevel\Protocol\ITask;

/**
 * 任务基本使用.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.07.02
 *
 * @version 1.0
 * @codeCoverageIgnore
 */
class Index
{
    /**
     * 执行入口.
     *
     * @param \Leevel\Protocol\ITask $task
     *
     * @return string
     */
    public function handle(ITask $task): string
    {
        $this->message('Start task');
        $task->task(TaskDemo::class.':4,5');

        return 'Task done';
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
