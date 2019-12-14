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

use Common\Domain\Entity\Demo\Test;
use Common\Infra\Helper\message_with_time;

/**
 * 实体查询.
 *
 * @codeCoverageIgnore
 */
class Entity
{
    /**
     * 响应.
     *
     * - 设置 .env DATABASE_DRIVER = mysql 或者 mysqlPool.
     */
    public function handle(): string
    {
        $this->message('Start');

        go(function () {
            $time = time();

            for ($i = 0; $i < 5; $i++) {
                $result = Test::select()->query('SELECT sleep(2)');
                dump($result);
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
