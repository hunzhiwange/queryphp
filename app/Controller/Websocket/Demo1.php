<?php

declare(strict_types=1);

namespace App\Controller\Websocket;

class Demo1
{
    public function handle(): string
    {
        return <<<HTML
<html lang="en">
<head>
  <meta charset="UTF-8">
</head>
<body>
    <h1>WebSocket Demo1</h1>
</body>
</html>
<script type="text/javascript">
var wsServer = 'ws://127.0.0.1:9502/websocket-demo1';
var websocket = new WebSocket(wsServer);
websocket.onopen = function (evt) {
    console.log("Connected to WebSocket server.");
    websocket.send('hello');
};

websocket.onclose = function (evt) {
    console.log("Disconnected");
};

websocket.onmessage = function (evt) {
    console.log('Retrieved data from server: ' + evt.data);
};

websocket.onerror = function (evt, e) {
    console.log('Error occured: ' + evt.data);
};
</script>
HTML;
    }
}
