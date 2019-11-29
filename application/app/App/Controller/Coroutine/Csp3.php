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

use Common\Infra\Helper\message_with_time;
use Swoole\Coroutine\Channel;
use Swoole\Coroutine\Http\Client;

/**
 * 协程：Go + Chan + Defer.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.07.26
 *
 * @version 1.0
 *
 * @see https://wiki.swoole.com/wiki/page/p-csp.html
 * @codeCoverageIgnore
 */
class Csp3
{
    /**
     * 改变顺序.
     *
     * @return string
     */
    public function handle(): string
    {
        $this->message('Start');

        $chan = new Channel(2);

        // 协程1
        go(function () use ($chan) {
            $result = [];
            for ($i = 0; $i < 2; $i++) {
                $result += $chan->pop();
            }
            $this->message(json_encode($result));
        });

        // 协程2
        go(function () use ($chan) {
            $cli = new Client('www.qq.com', 80);
            $cli->set(['timeout' => 10]);
            $cli->setHeaders([
                'Host'            => 'www.qq.com',
                'User-Agent'      => 'Chrome/49.0.2587.3',
                'Accept'          => 'text/html,application/xhtml+xml,application/xml',
                'Accept-Encoding' => 'gzip',
            ]);
            $ret = $cli->get('/');
            // $cli->body 响应内容过大，这里用 Http 状态码作为测试
            $chan->push(['www.qq.com' => $cli->statusCode]);
        });

        // 协程3
        go(function () use ($chan) {
            $cli = new Client('www.163.com', 80);
            $cli->set(['timeout' => 10]);
            $cli->setHeaders([
                'Host'            => 'www.163.com',
                'User-Agent'      => 'Chrome/49.0.2587.3',
                'Accept'          => 'text/html,application/xhtml+xml,application/xml',
                'Accept-Encoding' => 'gzip',
            ]);
            $ret = $cli->get('/');
            // $cli->body 响应内容过大，这里用 Http 状态码作为测试
            $chan->push(['www.163.com' => $cli->statusCode]);
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
