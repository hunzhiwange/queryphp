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
use queryyetsimple\debug\dump;
use queryyetsimple\http\request;
use queryyetsimple\router\router;
use queryyetsimple\filesystem\directory;

/**
 * 异常消息
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.04
 * @version 1.0
 */
class exception_message extends message {
    
    /**
     * 异常组件
     *
     * @var object
     */
    private $objException;
    
    /**
     * 构造函数
     *
     * @param object $objException            
     * @return void
     */
    public function __construct($objException) {
        $this->objException = $objException;
        $this->strMessage = "[{$this->objException->getCode ()}] {$this->objException->getMessage ()} " . basename ( $this->objException->getFile () ) . __ ( " 第 %d 行", $this->objException->getLine () );
    }
    
    /**
     * 错误消息执行入口
     *
     * @return void
     */
    public function run() {
        $this->log_ ( $this->strMessage );
        $this->errorMessage_ ( $this->format_ ( $this->objException ) );
    }
    
    /**
     * 输入异常消息
     *
     * @param mixed $mixError            
     * @return void
     */
    protected function errorMessage_($mixError) {
        if (! is_array ( $mixError )) {
            $mixError = [ 
                    'message' => $mixError 
            ];
        }
        
        // 否则定向到错误页面
        if (! request::isClis () && option::gets ( 'show_exception_redirect' ) && Q_DEBUG === false) {
            static::urlRedirect ( router::url ( option::gets ( 'show_exception_redirect' ) ) );
        } else {
            if (! option::gets ( 'show_exception_show_message', true ) && option::gets ( 'show_exception_default_message' )) {
                $mixError ['message'] = option::gets ( 'show_exception_default_message' );
            }
            
            // 包含异常页面模板
            if (request::isClis ()) {
                echo $mixError ['message'];
            } else {
                if (option::gets ( 'show_exception_template' ) && is_file ( option::gets ( 'show_exception_template' ) )) {
                    include option::gets ( 'show_exception_template' );
                } else {
                    include Q_PATH . '/resource/template/exception.php';
                }
            }
        }
    }
    
    /**
     * 格式化消息
     *
     * @param object $oException            
     * @return array
     */
    private function format_($oException) {
        // 返回消息
        $arrError = [ ];
        
        // 反转一下
        $arrTrace = array_reverse ( $oException->getTrace () );
        
        // 调试消息
        $sTraceInfo = '';
        if (Q_DEBUG) {
            foreach ( $arrTrace as $intKey => $arrVal ) {
                // 参数处理
                $arrVal ['class'] = isset ( $arrVal ['class'] ) ? $arrVal ['class'] : '';
                $arrVal ['type'] = isset ( $arrVal ['type'] ) ? $arrVal ['type'] : '';
                $arrVal ['function'] = isset ( $arrVal ['function'] ) ? $arrVal ['function'] : '';
                $arrVal ['file'] = isset ( $arrVal ['file'] ) ? directory::tidyPathLinux ( $arrVal ['file'] ) : '';
                $arrVal ['line'] = isset ( $arrVal ['line'] ) ? $arrVal ['line'] : '';
                $arrVal ['args'] = isset ( $arrVal ['args'] ) ? $arrVal ['args'] : '';
                
                // 参数格式化组装
                $sArgsInfo = $sArgsInfoDetail = '';
                if (is_array ( $arrVal ['args'] )) {
                    foreach ( $arrVal ['args'] as $intArgsKey => $mixArgsVal ) {
                        // 概要参数
                        $sArgsInfo .= ($intArgsKey !== 0 ? ', ' : '') . (is_scalar ( $mixArgsVal ) ? strip_tags ( var_export ( $mixArgsVal, true ) ) : gettype ( $mixArgsVal ));
                        
                        // 详细参数值
                        ob_start ();
                        dump::dump ( $mixArgsVal );
                        $sArgsInfoDetail .= '<div class="queryphp-message-argstitle">Args ' . ($intArgsKey + 1) . '</div><div class="queryphp-message-args">' . ob_get_contents () . '</div>';
                        ob_end_clean ();
                    }
                }
                
                // 调试信息
                $sTraceInfo .= "<li><a " . ($sArgsInfoDetail ? "data-toggle=\"queryphp-message-argsline-{$intKey}\" style=\"cursor: pointer;\"" : '') . "><span>#{$arrVal['line']}</span> {$arrVal['file']} - {$arrVal['class']}{$arrVal['type']}{$arrVal['function']}( {$sArgsInfo} )</a>
                " . ($sArgsInfoDetail ? "<div class=\"queryphp-message-argsline-{$intKey}\" style=\"display:none;\">
                {$sArgsInfoDetail}
                </div>" : '') . "
                </li>";
                
                unset ( $sArgsInfo, $sArgsInfoDetail );
            }
            $arrError ['trace'] = $sTraceInfo;
            unset ( $sTraceInfo);
        }
        
        // 调试消息
        $arrError ['message'] = $oException->getMessage ();
        $arrError ['type'] = isset ( $arrVal ['type'] ) ? $arrVal ['type'] : '';
        $arrError ['class'] = isset ( $arrTrace ['0'] ['class'] ) ? $arrTrace ['0'] ['class'] : '';
        $arrError ['code'] = $oException->getCode ();
        $arrError ['function'] = isset ( $arrTrace ['0'] ['function'] ) ? $arrTrace ['0'] ['function'] : '';
        $arrError ['line'] = $oException->getLine ();
        $arrError ['excetion_type'] = get_class ( $oException );
        
        return $arrError;
    }
}