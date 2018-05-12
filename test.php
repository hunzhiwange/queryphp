<?php
$http = new swoole_http_server("0.0.0.0", 9501);

$http->on("start", function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$http->on("request", function ($request, $response) {
    $response->header("Content-Type22", "text/plain");
    $response->status(500);
    $response->end("Hello World\n");
});

$http->start();