<?php

declare(strict_types=1);

namespace App\Controller;

use Leevel\Server\Websocket;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\WebSocket\CloseFrame;
use Swoole\WebSocket\Frame;

class WebsocketDemo2
{
    /**
     * WebSocket 客户端与服务器建立连接并完成握手后.
     */
    public function open(Websocket $server, Request $request, Response $response, int $workerId): void
    {
        // 每一次客户端连接 最大连接数将增加
        $message = "欢迎 `用户{$request->fd}` 进入聊天室";

        foreach ($server->getConnections() as $connectionId => $connection) {
            // 排除自己
            if ($connectionId !== spl_object_id($response)) {
                $connection->push($message);
            }
        }

        throw new \Exception('1234');
    }

    /**
     * 处理消息.
     * 监听服务器收到来自客户端的数据帧.
     */
    public function message(Websocket $server, Request $request, Response $response, Frame $frame, int $workerId): void
    {
        // 向所有人广播
        foreach ($server->getConnections() as $connectionId => $connection) {
            // 排除自己
            if ($connectionId !== spl_object_id($response)) {
                $connection->push(json_encode(['fd' => '用户 '.$request->fd, 'data' => $frame->data]));
            }
        }
    }

    /**
     * 监听连接关闭事件
     * 每个浏览器连接关闭时执行一次, reload 时连接不会断开, 也就不会触发该事件.
     */
    public function close(Websocket $server, Request $request, Response $response, string|false|Frame|CloseFrame $frame, int $workerId): void
    {
        $message = "`用户 {$request->fd}` 退出了聊天室";

        foreach ($server->getConnections() as $connectionId => $connection) {
            // 排除自己
            if ($connectionId !== spl_object_id($response)) {
                $connection->push($message);
            }
        }
    }
}
