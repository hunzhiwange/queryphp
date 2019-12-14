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
 * 协程：实现 sync.WaitGroup 功能.
 *
 * @see https://wiki.swoole.com/wiki/page/p-waitgroup.html
 * @codeCoverageIgnore
 */
class WaitGroup
{
    /**
     * 改变顺序.
     */
    public function handle(): string
    {
        $this->message('Start');

        go(function () {
            $result = [];

            $wg = new BaseWaitGroup();
            $wg->add();

            // 启动第一个协程
            go(function () use ($wg, &$result) {
                // 启动一个协程客户端 client，请求淘宝首页
                $cli = new Client('www.taobao.com', 80);
                $cli->setHeaders([
                    'Host'            => 'www.taobao.com',
                    'User-Agent'      => 'Chrome/49.0.2587.3',
                    'Accept'          => 'text/html,application/xhtml+xml,application/xml',
                    'Accept-Encoding' => 'gzip',
                ]);
                $cli->set(['timeout' => 1]);
                $cli->get('/index.php');

                $result['taobao'] = $cli->body;
                $cli->close();

                $wg->done();
            });

            $wg->add();
            // 启动第二个协程
            go(function () use ($wg, &$result) {
                // 启动一个协程客户端 client，请求百度首页
                $cli = new Client('www.baidu.com', 80);
                $cli->setHeaders([
                    'Host'            => 'www.baidu.com',
                    'User-Agent'      => 'Chrome/49.0.2587.3',
                    'Accept'          => 'text/html,application/xhtml+xml,application/xml',
                    'Accept-Encoding' => 'gzip',
                ]);
                $cli->set(['timeout' => 1]);
                $cli->get('/index.php');

                $result['baidu'] = $cli->body;
                $cli->close();

                $wg->done();
            });

            // 挂起当前协程，等待所有任务完成后恢复
            $wg->wait();

            //这里 $result 包含了 2 个任务执行结果
            foreach ($result as $k => $v) {
                $this->message($k);
                $this->message($v);
            }
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

class BaseWaitGroup
{
    /**
     * 计数器.
     *
     * @var int
     */
    private $count = 0;

    /**
     * 通道.
     *
     * @var \Swoole\Coroutine\Channel[]
     */
    private $chan;

    /**
     * 构造函数.
     */
    public function __construct()
    {
        $this->chan = new Channel();
    }

    /**
     * 方法增加计数.
     */
    public function add(): void
    {
        $this->count++;
    }

    /**
     * 表示任务已完成.
     */
    public function done(): void
    {
        $this->chan->push(true);
    }

    /**
     * 等待所有任务完成恢复当前协程的执行.
     */
    public function wait(): void
    {
        while ($this->count--) {
            $this->chan->pop();
        }
    }
}
