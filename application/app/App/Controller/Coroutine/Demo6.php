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

use Co;
use Common\Infra\Helper\message_with_time;
use Redis;
use Swoole\Runtime;

/**
 * 协程.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.07.04
 *
 * @version 1.0
 *
 * @see https://www.jianshu.com/p/745b0b3ffae7
 * @codeCoverageIgnore
 */
class Demo6
{
    /**
     * Redis 测试.
     *
     * @return string
     */
    public function handle(): string
    {
        Runtime::enableCoroutine(false);

        $this->message('Start coroutine redis');

        // 同步版, redis 使用时会有 IO 阻塞
        $cnt = 10;
        for ($i = 0; $i < $cnt; $i++) {
            $redis = new Redis();
            $redis->connect('127.0.0.1', 6380);
            $redis->auth('123456');
            $redis->set('key', 'value');
            $value = $redis->get('key');
            if (in_array($i, [0, $cnt - 1], true)) {
                $message = sprintf('[Normal][%d]Redis test `key`:`%s`', $i, $value);
                $this->message($message);
            }
        }
        $this->message('Normal redis end');

        // 单协程版: 只有一个协程, 并没有使用到协程调度减少 IO 阻塞
        $cnt2 = 10;
        go(function () use ($cnt2) {
            for ($i2 = 0; $i2 < $cnt2; $i2++) {
                $redis = new Co\Redis();
                $redis->connect('127.0.0.1', 6380);
                $redis->auth('123456');
                $redis->set('key', 'value');
                $value = $redis->get('key');
                if (in_array($i2, [0, $cnt2 - 1], true)) {
                    $message = sprintf('[Single][%d]Redis test `key`:`%s`', $i2, $value);
                    $this->message($message);
                }
            }
        });
        $this->message('Single coroutine redis end');

        // 多协程版, 真正使用到协程调度带来的 IO 阻塞时的调度
        $cnt3 = 10;
        for ($i3 = 0; $i3 < $cnt3; $i3++) {
            go(function () use ($i3, $cnt3) {
                $redis = new Co\Redis();
                $redis->connect('127.0.0.1', 6380);
                $redis->auth('123456');
                $value = $redis->get('key');
                if (in_array($i3, [0, $cnt3 - 1], true)) {
                    $message = sprintf('[Coroutine][%d]Redis test `key`:`%s`', $i3, $value);
                    $this->message($message);
                }
            });
        }
        $this->message('Coroutine redis end');

        // 多协程版使用 `enableCoroutine`, 真正使用到协程调度带来的 IO 阻塞时的调度
        $cnt4 = 10;
        Runtime::enableCoroutine();
        for ($i4 = 0; $i4 < $cnt4; $i4++) {
            go(function () use ($i4, $cnt4) {
                $redis = new Redis();
                $redis->connect('127.0.0.1', 6380);
                $redis->auth('123456');
                $value = $redis->get('key');
                if (in_array($i4, [0, $cnt4 - 1], true)) {
                    $message = sprintf('[Enable Coroutine][%d]Redis test `key`:`%s`', $i4, $value);
                    $this->message($message);
                }
            });
        }
        $this->message('Enable Coroutine redis end');

        return 'Coroutine done';
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
