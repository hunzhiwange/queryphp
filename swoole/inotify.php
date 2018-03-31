<?php 

//创建一个inotify句柄
$fd = inotify_init();

//监听文件，仅监听修改操作，如果想要监听所有事件可以使用IN_ALL_EVENTS
$watch_descriptor = inotify_add_watch($fd, __DIR__.'/inotify.data', IN_MODIFY); 

// while (true) {
//     //阻塞地读取数据
//     $events = inotify_read($fd);
//     if ($events) {
//         foreach ($events as $event) {
//             echo "inotify Event :".var_export($event, 1)."\n";
//         }
//     }
// }
error_log("1", 3, __DIR__."/errors.log");

//加入到swoole的事件循环中
swoole_event_add($fd, function ($fd) {
    $events = inotify_read($fd);
    if ($events) {
        foreach ($events as $event) {
            error_log("2", 3, __DIR__."/errors.log");
            echo "inotify Event :" . var_export($event, 1) . "\n";
        }
    }
});

error_log("3", 3, __DIR__."/errors.log");

// //释放inotify句柄
// inotify_rm_watch($fd, $watch_descriptor);
// fclose($fd);