<?php

declare(strict_types=1);

// phpstan 静态检查启动文件.
include __DIR__.'/tests/bootstrap.php';

// 导入助手函数.
$fnDirs = [
    __DIR__.'/common/Infra/Helper',
];
foreach ($fnDirs as $dir) {
    $files = glob($dir.'/*.php');
    foreach ($files as $file) {
        include_once $file;
    }
}
