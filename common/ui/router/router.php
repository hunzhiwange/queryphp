<?php
// ©2017 http://your.domain.com All rights reserved.
use queryyetsimple\router;

/**
 * ---------------------------------------------------------------
 * 绑定全局中间件
 * ---------------------------------------------------------------
 *
 * 绑定全局中间件，区别 API 和 WEB
 * 基于当前开发模式读取对应的分组组件
 */
if (api()) {
    router::middleware('*', [
            'common',
            'api'
    ]);
} else {
    router::middleware('*', [
            'common',
            'web'
    ]);
}
