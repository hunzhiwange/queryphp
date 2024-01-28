<?php

declare(strict_types=1);

namespace App\Controller\Websocket;

class Index
{
    public function handle(): string
    {
        return <<<HTML
<html lang="en">
<head>
  <meta charset="UTF-8">
</head>
<body>
    <h1>Swoole WebSocket Server</h1>
    <ul>
        <li><a href="/websocket/demo1">demo1</a></li>
        <li><a href="/websocket/demo2">demo2</a></li>
    </ul>
</body>
</html>
HTML;
    }
}
