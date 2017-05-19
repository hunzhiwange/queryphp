<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\queue;

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

use PHPQueue\JobQueue;
use PHPQueue\Logger;
use queryyetsimple\filesystem\directory;

/**
 * base 消息队列
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.11
 * @version 1.0
 */
abstract class queue extends JobQueue {
    
    /**
     * 队列连接
     *
     * @var string
     */
    protected $strConnect;
    
    /**
     * 默认执行队列
     *
     * @var string
     */
    protected static $strQueue = 'default';
    
    /**
     * 消息队列日志路径
     *
     * @var string
     */
    protected static $strLogPath;
    
    /**
     * 连接句柄
     *
     * @var resource
     */
    protected $resDataSource;
    
    /**
     * 连接配置
     *
     * @var array
     */
    protected $arrSourceConfig = [ ];
    
    /**
     * 队列执行者
     *
     * @var string
     */
    protected $strQueueWorker;
    
    /**
     * 日志对象
     *
     * @var array
     */
    protected $objResultLog;
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct() {
        parent::__construct ();
        
        // 存储队列
        $this->arrSourceConfig ['queue'] = $this->makeSourceKey_ ();
        
        // 记录日志
        if (self::$strLogPath) {
            if (! is_dir ( self::$strLogPath ))
                directory::create ( self::$strLogPath );
            $this->objResultLog = Logger::createLogger ( $this->strConnect, Logger::INFO, self::$strLogPath . '/' . $this->strConnect . '.log' );
        }
    }
    
    /**
     * 设置消息队列
     *
     * @param string $strQueue            
     * @return void
     */
    public static function setQueue($strQueue = 'default') {
        static::$strQueue = $strQueue;
    }
    
    /**
     * 设置日志路径
     *
     * @param string $strLogPath            
     * @return void
     */
    public static function logPath($strLogPath) {
        static::$strLogPath = $strLogPath;
    }
    
    /**
     * 添加一个任务
     *
     * @param array $arrNewJob            
     * @return boolean
     */
    public function addJob($arrNewJob = null) {
        $arrFormattedData = [ 
                'worker' => $this->strQueueWorker,
                'data' => $arrNewJob 
        ];
        $this->resDataSource->add ( $arrFormattedData );
        return true;
    }
    
    /**
     * 获取一个任务
     *
     * @param string $strJobId            
     * @return object
     */
    public function getJob($strJobId = null) {
        $arrData = $this->resDataSource->get ();
        if (! class_exists ( $strJob = '\queryyetsimple\queue\jobs\\' . $this->strConnect )) {
            $strJob = '\PHPQueue\Job';
        }
        $objNextJob = new $strJob ( $arrData, $this->resDataSource->last_job_id,static::$strQueue );
        $this->last_job_id = $this->resDataSource->last_job_id;
        return $objNextJob;
    }
    
    /**
     * 更新任务
     *
     * @param string $strJobId            
     * @param array $arrResultData            
     * @return void
     */
    public function updateJob($strJobId = null, $arrResultData = null) {
        if (! $this->objResultLog)
            return;
        $this->arrResultLog->addInfo ( 'Result: ID=' . $strJobId, $arrResultData );
    }
    
    /**
     * 删除任务
     *
     * @param string $strJobId            
     * @return void
     */
    public function clearJob($strJobId = null) {
        $this->resDataSource->clear ( $strJobId );
    }
    
    /**
     * 重新发布任务
     *
     * @param string $strJobId            
     * @return void
     */
    public function releaseJob($strJobId = null) {
        $this->resDataSource->release ( $strJobId );
    }
    
    /**
     * 取得存储连接 key
     * redis:email 表示 redis 邮件队列
     *
     * @return string
     */
    protected function makeSourceKey_() {
        return $this->strConnect . ':' . static::$strQueue;
    }
}