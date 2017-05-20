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
 * 命令行相关配置文件
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.17
 * @version 1.0
 */
return [
        
        'custom' => [ ], // 自定义命令行
        
        // 命令行注释
        'template' => [
                // 头部注释
                'header_comment' => '// console_template.header_comment
// [{{product_name}}] {{product_description}} <{{product_slogan}}>
// ©{{date_y}}-2099 {{product_homepage}} All rights reserved.',
                
                // 文件头部注释
                'file_comment' => '// console_template.file_comment
/**
 * {{file_name}}
 *
 * @author {{file_author}}
 * @package {{file_package}}
 * @since {{file_since}}
 * @version {{file_version}}
 */',
                
                // 产品信息
                'product_homepage' => 'http://www.youdomain.com',
                'product_name' => 'Your.Product',
                'product_description' => 'This project can help people to do things very funny.',
                'product_slogan' => 'To make the world better',
                
                // 文件头部替换
                'file_name' => '',
                'file_since' => date ( 'Y.m.d' ),
                'file_version' => '1.0',
                'file_package' => '$$',
                'file_author' => 'your.name<your.email>' 
        ] 
]; 
