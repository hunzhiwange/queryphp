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
 * cookie 配置文件
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
return [ 
        
        /**
         * cookie
         */
        
        /**
         * enable the browse pointer
         * see also BrowsePointerColor
         * in layout.inc.php
         *
         * @global boolean $cfg['BrowsePointerEnable']
         */
        'prefix' => 'q_', // cookie 前缀
        
        /**
         * enable the browse pointer
         * see also BrowsePointerColor
         * in layout.inc.php
         *
         * @global boolean $cfg['BrowsePointerEnable']
         */
        'langtheme_app' => true, // 语言包和模板 cookie 是否包含应用名
        
        /**
         * enable the browse pointer
         * see also BrowsePointerColor
         * in layout.inc.php
         *
         * @global boolean $cfg['BrowsePointerEnable']
         */
        'domain' => '', // cookie 域名
        
        /*
         * --------------------------------------------------------------------------
         * Cache Stores
         * --------------------------------------------------------------------------
         *
         * Here you may define all of the cache "stores" for your application as
         * well as their drivers. You may even define multiple stores for the
         * same cache driver to group types of items stored in your caches.
         */
        'path' => '/', // cookie 路径
        'expire' => 86400 
]; // cookie 默认过期时间一天


