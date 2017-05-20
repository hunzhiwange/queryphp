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
         * 缓存系统   
         */
        'default' => 'filecache', // 程序运行指定缓存
        
        'prefix' => '~@', // 缓存键值前缀
        'nocache_force' => '~@nocache_force', // 缓存调试 GET 参数，强制不启用缓存
        'expiration_time' => 86400, // 程序缓存时间
        
        'time_preset' => [ ], // 缓存时间预置,键值=缓存值，键值不带前缀 ['option' => 60]
        
        'connect' => [ 
                'filecache' => [ 
                        'path' => '' 
                ], // 文件缓存路径
                
                'memcache' => [ 
                        'servers' => [ ], // memcache 多台服务器
                        'host' => '127.0.0.1', // memcache 默认缓存服务器
                        'port' => 11211, // memcache 默认缓存服务器端口
                        'compressed' => false, // memcache 是否压缩缓存数据
                        'persistent' => true 
                ] 
        ] // memcache 是否使用持久连接

         
]; 
