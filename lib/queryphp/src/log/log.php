<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2017.03.03
 * @since 1.0
 */
namespace Q\log;

/**
 * 日志
 *
 * @author Xiangmin Liu
 */
class log {
    
    /**
     * 当前记录的日志信息
     *
     * @var array
     */
    public static $arrLog = [ ];
    
    /**
     * 记录错误消息
     *
     * @param string $strMessage
     *            应该被记录的错误信息
     * @param string $strLevel
     *            日志错误类型，例如 error,sql,custom
     * @param int $intMessageType
     *            参考 error_log 参数 $message_type
     * @param string $strDestination
     *            参考 error_log 参数 $destination
     * @param string $strExtraHeaders
     *            参考 error_log 参数 $extra_headers
     */
    static public function run($strMessage, $strLevel = 'error', $intMessageType = 3, $strDestination = '', $strExtraHeaders = '') {
        // 是否开启日志
        if (! $GLOBALS ['~@option'] ['log_enabled']) {
            return;
        }
        
        // 只记录系统允许的日志级别
        if (in_array ( $strLevel, explode ( ',', $GLOBALS ['~@option'] ['log_level'] ) )) {
            // 日志消息
            $strMessage = date ( $GLOBALS ['~@option'] ['log_time_format'] ) . "[{$strLevel}]{$strMessage}\r\n";
            
            // 保存日志
            $strDestination = self::getLogPath_ ( $strLevel, $strDestination );
            if ($intMessageType == 3) {
                self::checkLogSize_ ( $strDestination );
            }
            error_log ( $strMessage, $intMessageType, $strDestination, $strExtraHeaders );
            self::$arrLog [] = $strMessage;
        }
    }
    
    /**
     * 清理日志记录
     *
     * @return number
     */
    static public function clear() {
        $nCount = count ( self::$arrLog );
        self::$arrLog = [ ];
        return $nCount;
    }
    
    /**
     * 获取日志记录数量
     *
     * @return number
     */
    static public function getCount() {
        return count ( self::$arrLog );
    }
    
    /**
     * 验证日志文件大小
     *
     * @param string $sFilePath            
     * @return void
     */
    static private function checkLogSize_($sFilePath) {
        // 如果不是文件，则创建
        if (! is_file ( $sFilePath ) && ! is_dir ( dirname ( $sFilePath ) ) && ! \Q::makeDir ( dirname ( $sFilePath ) )) {
            \Q::throwException ( \Q::i18n ( '无法创建日志文件：“%s”', $sFilePath ) );
        }
        
        // 检测日志文件大小，超过配置大小则备份日志文件重新生成
        if (is_file ( $sFilePath ) && floor ( $GLOBALS ['~@option'] ['log_file_size'] ) <= filesize ( $sFilePath )) {
            rename ( $sFilePath, dirname ( $sFilePath ) . '/' . date ( 'Y-m-d H.i.s' ) . '~@' . basename ( $sFilePath ) );
        }
    }
    
    /**
     * 获取日志路径
     *
     * @param string $strLevel            
     * @param string $sFilePath            
     * @return string
     */
    static private function getLogPath_($strLevel, $sFilePath = '') {
        // 不存在路径，则直接使用项目默认路径
        if (empty ( $sFilePath )) {
            $sFilePath = \Q::app ()->logcache_path . '/' . $strLevel . '/' . date ( $GLOBALS ['~@option'] ['log_file_name'] ) . ".log";
        }
        return $sFilePath;
    }
}
