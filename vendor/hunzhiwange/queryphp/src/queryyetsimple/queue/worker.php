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

use Clio\Console;
use PHPQueue\Worker as PHPQueueWorker;

/**
 * 基类 worker
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.11
 * @version 1.0
 */
abstract class worker extends PHPQueueWorker {
    
    /**
     * 运行任务
     *
     * @param \PHPQueue\Job $objJob            
     * @return void
     */
    public function runJob($objJob) {
        parent::runJob ( $objJob );
        
        $arrJobData = $objJob->data;
        
        if (empty ( $arrJobData ['~@job'] )) {
            $this->formatMessage_ ( 'Job name is not defined.' );
            return $this->result_data = [ ];
        }
        
        $this->formatMessage_ ( sprintf ( 'Trying do run job %s.', $arrJobData ['~@job'] ) );
        
        try {
            // 注入构造器
            $objJob = $this->getObjectByClassAndArgs_ ( $arrJobData ['~@job'], $arrJobData );
            
            // 注入方法
            $strMethod = method_exists ( $objJob, 'handle' ) ? 'handle' : 'fire';
            $this->getObjectCallbackResultWithMethodArgs_ ( [ 
                    $objJob,
                    $strMethod 
            ], $arrJobData );
        } catch ( \Exception $oE ) {
            $this->formatMessage_ ( $oE->getMessage () );
            return $this->result_data = [ ];
        }
        
        $this->formatMessage_ ( sprintf ( 'Job %s is done.' . "", $arrJobData ['~@job'] ) );
        $this->formatMessage_ ( 'Starting the next. ' );
        
        $this->result_data = $arrJobData;
    }
    
    /**
     * 格式化输出消息
     *
     * @param string $strMessage            
     * @return string
     */
    protected function formatMessage_($strMessage) {
        Console::stdout ( sprintf ( '[%s]', date ( 'H:i:s' ) ) . $strMessage . PHP_EOL );
    }
}
