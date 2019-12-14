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

/**
 * phpstan 静态检查启动文件.
 */
include __DIR__.'/tests/bootstrap.php'; /** @codeCoverageIgnore */

/**
 * 导入助手函数.
 *
 * @codeCoverageIgnoreStart
 */
$fnDirs = [
    __DIR__.'/common/Infra/Helper',
];

foreach ($fnDirs as $dir) {
    $files = glob($dir.'/*.php');

    foreach ($files as $file) {
        include_once $file;
    }
}
// @codeCoverageIgnoreEnd
