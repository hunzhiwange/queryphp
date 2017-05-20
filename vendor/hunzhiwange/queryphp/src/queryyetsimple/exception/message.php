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

use queryyetsimple\option\option;
use queryyetsimple\log\log;

/**
 * 消息基类
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.04
 * @version 1.0
 */
abstract class message {
    
    /**
     * 错误消息
     *
     * @var string
     */
    protected $strMessage;
    
    /**
     * 错误消息执行入口
     *
     * @return void
     */
    public function run() {
        if ($this->strMessage) {
            $this->log_ ( $this->strMessage );
            $this->errorMessage_ ( $this->strMessage );
        }
    }
    
    /**
     * 记录日志
     *
     * @param string $strMessage            
     * @return void
     */
    protected function log_($strMessage) {
        if (option::gets ( 'log_error_enabled', false )) {
            log::runs ( $strMessage, 'error' );
        }
    }
    
    /**
     * 输出一个致命错误
     *
     * @param string $sMessage            
     * @return void
     */
    protected function errorMessage_($sMessage) {
        require_once Q_PATH . '/resource/template/error.php';
    }
}