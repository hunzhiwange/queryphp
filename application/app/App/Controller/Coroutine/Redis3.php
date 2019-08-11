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
use Swoole\Coroutine\Channel;

/**
 * Redis.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.07.27
 *
 * @version 1.0
 */
class Redis3
{
    /**
     * 响应.
     *
     * - 设置 .env CACHE_DRIVER = redis 或者 redisPool.
     *
     * @return string
     */
    public function handle(): string
    {
        $this->message('Start');

        go(function () {
            $time = time();
            $chan = new Channel();

            for ($i = 0; $i < 5; $i++) {
                go(function () use ($chan, $i) {
                    App::make('cache')->set('h'.$i, 'w');
                    $result = App::make('cache')->get('h'.$i);
                    $chan->push($result);
                    sleep(1);
                });
            }

            for ($i = 0; $i < 5; $i++) {
                $result = $chan->pop();
                dump($result);
            }

            $this->message('Time: '.(time() - $time));
        });

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
