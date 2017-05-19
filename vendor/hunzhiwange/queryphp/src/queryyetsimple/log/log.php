<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\log;

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

use queryyetsimple\traits\dynamic\expansion as dynamic_expansion;
use queryyetsimple\option\option;
use queryyetsimple\exception\exceptions;
use queryyetsimple\assert\assert;
use queryyetsimple\mvc\project;
use queryyetsimple\filesystem\directory;

/**
 * 日志
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.03.03
 * @version 1.0
 */
class log {
    
    use dynamic_expansion;
    
    /**
     * 当前记录的日志信息
     *
     * @var array
     */
    private $arrLog = [ ];
    
    /**
     * 日志过滤器
     *
     * @var callable
     */
    private $calFilter = null;
    
    /**
     * 日志处理器
     *
     * @var callable
     */
    private $calProcessor = null;
    
    /**
     * 配置
     *
     * @var array
     */
    protected $arrInitExpansionInstanceArgs = [ 
            'log\enabled' => false,
            'log\level' => 'error,sql,debug,info',
            'log\error_enabled' => false,
            'log\sql_enabled' => false,
            'log\time_format' => '[Y-m-d H:i]',
            'log\file_size' => 2097152,
            'log\file_name' => 'Y-m-d H',
            'log\path_default' => '' 
    ];
    
    /**
     * 记录错误消息
     *
     * @param string $strMessage
     *            应该被记录的错误信息
     * @param string $strLevel
     *            日志错误类型，系统日志 error,sql,自定义其它日志 custom
     * @param int $intMessageType
     *            参考 error_log 参数 $message_type
     * @param string $strDestination
     *            参考 error_log 参数 $destination
     * @param string $strExtraHeaders
     *            参考 error_log 参数 $extra_headers
     * @return void
     */
    public function run($strMessage, $strLevel = 'info', $intMessageType = 3, $strDestination = '', $strExtraHeaders = '') {
        // 是否开启日志
        if (! $this->getExpansionInstanceArgs_ ( 'log\enabled' )) {
            return;
        }
        
        // 错误日志和 sql 日志
        if ((! $this->getExpansionInstanceArgs_ ( 'log\error_enabled' ) && $strLevel == 'error') || (! $this->getExpansionInstanceArgs_ ( 'log\sql_enabled' ) && $strLevel == 'sql')) {
            return;
        }
        
        // 只记录系统允许的日志级别
        if (! in_array ( $strLevel, explode ( ',', $this->getExpansionInstanceArgs_ ( 'log\level' ) ) )) {
            return;
        }
        
        // 执行过滤器
        if ($this->calFilter !== null && call_user_func_array ( $this->calFilter, [ 
                $strMessage,
                $strLevel 
        ] ) === false) {
            return;
        }
        
        // 日志消息
        $strMessage = date ( $this->getExpansionInstanceArgs_ ( 'log\time_format' ) ) . $strMessage . "\r\n";
        
        // 保存日志
        $strDestination = $this->getPath_ ( $strLevel, $strDestination );
        if ($intMessageType == 3) {
            $this->checkSize_ ( $strDestination );
        }
        
        // 记录到系统
        error_log ( $strMessage, $intMessageType, $strDestination, $strExtraHeaders );
        
        // 记录到内存方便后期调用
        if (! isset ( $this->arrLog [$strLevel] )) {
            $this->arrLog [$strLevel] = [ ];
        }
        $this->arrLog [$strLevel] [] = $strMessage;
        
        // 执行处理器
        if ($this->calProcessor !== null) {
            call_user_func_array ( $this->calProcessor, [ 
                    $strMessage,
                    $strLevel 
            ] );
        }
    }
    
    /**
     * 注册日志过滤器
     *
     * @param callable $calFilter            
     * @return void
     */
    public function registerFilter($calFilter) {
        assert::callback ( $calFilter );
        $this->calFilter = $calFilter;
    }
    
    /**
     * 注册日志处理器
     *
     * @param callable $calProcessor            
     * @return void
     */
    public function registerProcessor($calProcessor) {
        assert::callback ( $calProcessor );
        $this->calProcessor = $calProcessor;
    }
    
    /**
     * 清理日志记录
     *
     * @return number
     */
    public function clear() {
        $nCount = count ( $this->arrLog );
        $this->arrLog = [ ];
        return $nCount;
    }
    
    /**
     * 获取日志记录
     *
     * @return array
     */
    public function get() {
        return $this->arrLog;
    }
    
    /**
     * 获取日志记录数量
     *
     * @return number
     */
    public function count() {
        return count ( $this->arrLog );
    }
    
    /**
     * 验证日志文件大小
     *
     * @param string $sFilePath            
     * @return void
     */
    private function checkSize_($sFilePath) {
        // 如果不是文件，则创建
        if (! is_file ( $sFilePath ) && ! is_dir ( dirname ( $sFilePath ) ) && ! directory::create ( dirname ( $sFilePath ) )) {
            exceptions::throwException ( __ ( '无法创建日志文件：“%s”', $sFilePath ), 'queryyetsimple\log\exception' );
        }
        
        // 检测日志文件大小，超过配置大小则备份日志文件重新生成
        if (is_file ( $sFilePath ) && floor ( $this->getExpansionInstanceArgs_ ( 'log\file_size' ) ) <= filesize ( $sFilePath )) {
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
    private function getPath_($strLevel, $sFilePath = '') {
        // 不存在路径，则直接使用项目默认路径
        if (empty ( $sFilePath )) {
            $sFilePath = $this->getExpansionInstanceArgs_ ( 'log\path_default' ) . '/' . $strLevel . '/' . date ( $this->getExpansionInstanceArgs_ ( 'log\file_name' ) ) . ".log";
        }
        return $sFilePath;
    }
    
    /**
     * 初始化动态扩展参数
     *
     * @return void
     */
    protected function initExpansionInstance_() {
        return $this->initExpansionInstanceDefault_ ()->setExpansionInstanceArgs ( 'log\path_default', project::bootstrap ()->path_cache_log );
    }
}
