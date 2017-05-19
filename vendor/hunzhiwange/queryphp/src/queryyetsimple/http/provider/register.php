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
 * http.register 服务提供者
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.12
 * @version 1.0
 */
return [ 
        'singleton@request' => [ 
                'queryyetsimple\http\request',
                function ($objProject) {
                    return \queryyetsimple\http\request::getNewInstance ( $objProject );
                } 
        ],
        'singleton@response' => [ 
                'queryyetsimple\http\response',
                function ($objProject) {
                    return \queryyetsimple\http\response::getNewInstance ( $objProject );
                } 
        ] 
];
