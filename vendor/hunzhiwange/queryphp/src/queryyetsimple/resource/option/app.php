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
        
        'namespace' => [ ], // 自定义命名空间 （名字=入口路径）
        
        'default_app' => 'home', // 默认应用
        'default_controller' => 'index', // 默认控制器
        'default_action' => 'index', // 默认方法
        
        
        
        '~apps~' => [ ], // 默认 app 名字
        
        
        'provider' => [ ], // 应用提供者
        'provider_with_cache' => [ 
              //  'queryyetsimple\log\provider\log',
                //'queryyetsimple\option\provider\option',
               // 'queryyetsimple\http\provider\response' 
        ], // 具有缓存功能的服务提供者
        
        

        /**
         * 杂项
         */
        'option_extend' => [], 
        'router_extend' => ['yes','goods'],
        'start_gzip' => true, // Gzip 压缩
        'time_zone' => 'Asia/Shanghai', // 时区
        'q_auth_key' => 'queryphp-872-028-111-222-sn7i', // 安全 key
        'upload_file_rule' => 'time', // 文件上传保存文件名函数

]; // memcache 是否使用持久连接
