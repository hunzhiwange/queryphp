<?php

declare(strict_types=1);

namespace App\Controller;

use Leevel\Server\Websocket;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\WebSocket\CloseFrame;
use Swoole\WebSocket\Frame;

class WebsocketDemo1
{
    /**
     * WebSocket 客户端与服务器建立连接并完成握手后.
     */
    public function open(Websocket $server, Request $request, Response $response, int $workerId): void
    {
    }

    /**
     * 处理消息.
     * 监听服务器收到来自客户端的数据帧.
     */
    public function message(Websocket $server, Request $request, Response $response, int $workerId, Frame $frame): void
    {
        $response->push("Hello {$frame->data}!");
        $response->push("How are you, {$frame->data}?");
    }

    /**
     * 监听连接关闭事件
     * 每个浏览器连接关闭时执行一次, reload 时连接不会断开, 也就不会触发该事件.
     */
    public function close(Websocket $server, Request $request, Response $response, int $workerId, string|false|Frame|CloseFrame $frame): void
    {
    }
}
