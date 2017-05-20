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
         * Url相关
         */
        'model' => 'pathinfo', // default = 普通，pathinfo = pathinfo 模式
        'rewrite' => false, // 是否开启重写
        'pathinfo_depr' => '/', // url 分割符
        'html_suffix' => '.html', // 伪静态后缀
        'router_cache' => true,// 缓存路由
        'router_on' => true, // 是否开启 url 路由
        'router_strict' => false, // 是否启用严格 url 匹配模式
        'router_extend' => '', // 路由扩展支持文件
        'router_domain_on' => false, // 是否开启域名路由解析
        'router_domain_top' => '', // 顶级域名，如 queryphp.com
        'make_subdomain_on' => false, // 是否开启子域名
        
]; 
