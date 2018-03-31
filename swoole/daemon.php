<?php
require __DIR__ . '/AutoReload.php';
//存放SWOOLE服务的PID
$file = __DIR__ . '/../runtime/swoole/pid/http.pid';
if (file_exists($file)) {
    $pid = file_get_contents($file);
    $kit = new AutoReload((int)$pid);
    $kit->watch(__DIR__ . '/../demo');//监控的目录
    $kit->run();
}