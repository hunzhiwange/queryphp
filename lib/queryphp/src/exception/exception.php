<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2017.01.09
 * @since 1.0
 */
namespace Q\exception;

use Q;

/**
 * 异常捕获
 *
 * @author Xiangmin Liu
 */
class exception extends \exception {
    
    /**
     * 构造函数
     *
     * @param string $sMessage            
     * @param number $nCode            
     * @return void
     */
    public function __construct($sMessage, $nCode = 0) {
        parent::__construct ( $sMessage, $nCode );
    }
    
    /**
     * 对象字符串
     *
     * @see Exception::__toString()
     * @return string
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
    /**
     * 格式化消息
     *
     * @return array
     */
    public function formatException() {
        // 返回消息
        $arrError = [ ];
        
        // 反转一下
        $arrTrace = array_reverse ( $this->getTrace () );
        
        // 调试消息
        $sTraceInfo = '';
        if (Q_DEBUG) {
            foreach ( $arrTrace as $intKey => $arrVal ) {
                // 参数处理
                $arrVal ['class'] = isset ( $arrVal ['class'] ) ? $arrVal ['class'] : '';
                $arrVal ['type'] = isset ( $arrVal ['type'] ) ? $arrVal ['type'] : '';
                $arrVal ['function'] = isset ( $arrVal ['function'] ) ? $arrVal ['function'] : '';
                $arrVal ['file'] = isset ( $arrVal ['file'] ) ? $arrVal ['file'] : '';
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
                        Q::dump ( $mixArgsVal );
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
            unset ( $sTraceInfo );
        }
        
        // 调试消息
        $arrError ['message'] = $this->message;
        $arrError ['type'] = $arrVal ['type'];
        $arrError ['class'] = isset ( $arrTrace ['0'] ['class'] ) ? $arrTrace ['0'] ['class'] : '';
        $arrError ['code'] = $this->getCode ();
        $arrError ['function'] = isset ( $arrTrace ['0'] ['function'] ) ? $arrTrace ['0'] ['function'] : '';
        $arrError ['line'] = $this->line;
        
        return $arrError;
    }

}
