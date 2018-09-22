<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    /*
     * ---------------------------------------------------------------
     * 是否打开 JSON 调试
     * ---------------------------------------------------------------
     *
     * 返回接口中显示系统注入的调试信息
     */
    'json' => Leevel::env('DEBUG_JSON', true),

    /*
     * ---------------------------------------------------------------
     * 是否打开 Javascript 调试
     * ---------------------------------------------------------------
     *
     * 浏览器控制台中显示系统注入的调试信息
     */
    'console' => Leevel::env('DEBUG_CONSOLE', true),

    /*
     * ---------------------------------------------------------------
     * 是否打开 Javascript 调试
     * ---------------------------------------------------------------
     *
     * 浏览器底部中显示系统注入的调试信息
     */
    'javascript' => Leevel::env('DEBUG_JAVASCRIPT', true),
];
