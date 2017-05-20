<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
<<<queryphp
##########################################################
#   ____                          ______  _   _ ______   #
#  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
# |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
#  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
#       \__   | \___ |_|    \__  || |    | | | || |      #
#     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
#                          |___ /  Since 2010.10.03      #
##########################################################
queryphp;

/**
 * 系统默认配置文件
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
return [ 
        
        /**
         * 主题 && 语言包
         */
        'cookie_app' => false,
        'cache_lifetime' => - 1, // 模板编译缓存时间,单位秒,-1 表示永不过期
        'cache_children' => false, // 模板编译是否将子模板的缓存写入父模板以达到降低 IO 开销
        'switch' => true, // 是否允许模板切换
        'default' => 'default', // 模板默认主题
        'tag_note' => false, // 注释版标签风格
        'notallows_func' => 'exit,die,return', // 系统不允许解析的函数-英文半角“,”隔开*
        'notallows_func_js' => 'alert', // js 不允许函数
        'suffix' => '.html', // 模板后缀
        'var_identify' => '', // 为空表示模板解析自动识别为 obj,array
        'action_fail' => 'public+fail', // 默认错误跳转对应的模板文件
        'action_success' => 'public+success', // 默认成功跳转对应的模板文件
        'moduleaction_depr' => '_', // 默认模块和方法分割符
        'strip_space' => true 
] // 模板编译文件是否清除空格

; // memcache 是否使用持久连接
