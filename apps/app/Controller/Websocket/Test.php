<?php

declare(strict_types=1);

namespace App\Controller\Websocket;

use Leevel\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

/**
 * Websocket tests.
 *
 * @codeCoverageIgnore
 */
class Test
{
    /**
     * WebSocket 客户端与服务器建立连接并完成握手后.
     *
     * @see https://wiki.swoole.com/wiki/page/401.html
     */
    public function open(Server $server, Request $request, int $fd)
    {
        //每一次客户端连接 最大连接数将增加
        $message = "欢迎 `用户{$fd}` 进入聊天室";

        foreach ($server->connections as $key => $value) {
            // 排除自己
            if ($fd !== $value) {
                $server->push($value, $message);
            }
        }
    }

    /**
     * 处理消息.
     * 监听服务器收到来自客户端的数据帧.
     *
     * @see https://wiki.swoole.com/wiki/page/397.html
     */
    public function message(Server $server, Frame $frame, int $fd): void
    {
        // 向所有人广播
        foreach ($server->connections as $key => $value) {
            if ($fd !== $value) {
                $server->push($value, json_encode(['fd' => '用户 '.$fd, 'data' => $frame->data]));
            }
        }
    }

    /**
     * 监听连接关闭事件
     * 每个浏览器连接关闭时执行一次, reload 时连接不会断开, 也就不会触发该事件.
     *
     * @see https://wiki.swoole.com/wiki/page/p-event/onClose.html
     */
    public function close(Server $server, int $fd, int $reactorId): void
    {
        $message = "`用户 {$fd}` 退出了聊天室";

        foreach ($server->connections as $key => $value) {
            if ($fd !== $value) {
                $server->push($value, $message);
            }
        }
    }
}
