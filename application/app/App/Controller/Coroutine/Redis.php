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

use App;
use Common\Infra\Helper\message_with_time;

/**
 * Redis.
 *
 * @codeCoverageIgnore
 */
class Redis
{
    /**
     * 响应.
     *
     * - 设置 .env CACHE_DRIVER = redis 或者 redisPool.
     */
    public function handle(): string
    {
        $this->message('Start');

        go(function () {
            $time = time();

            for ($i = 0; $i < 5; $i++) {
                App::make('cache')->set('h'.$i, 'w');
                $result = App::make('cache')->get('h'.$i);
                dump($result);
                sleep(1);
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
