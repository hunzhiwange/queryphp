<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\exception;

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
 * 错误消息
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.04
 * @version 1.0
 */
class error_message extends message {
    
    /**
     * 构造函数
     *
     * @param int $nErrorNo            
     * @param string $sErrStr            
     * @param string $sErrFile            
     * @param int $nErrLine            
     * @return void
     */
    public function __construct($nErrorNo, $sErrStr, $sErrFile, $nErrLine) {
        if ($nErrorNo) {
            $this->strMessage = "[{$nErrorNo}]: {$sErrStr}<br> File: {$sErrFile}<br> Line: {$nErrLine}";
        }
    }
}