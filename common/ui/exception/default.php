<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.

/**
 * 系统异常模版
 *
 * @author Xiangmin Liu <635750556@qq.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
$title = isset($type) ? $type : 'Whoops!';

if (! isset($message)) {
    $message = 'Unknown error.';
}

if (isset($file) && isset($line)) {
    $title .= sprintf('<div class="file">#FILE %s #LINE %s</div>', $file, $line);
}

require dirname(__FILE__) . '/layout.php';
