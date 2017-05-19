<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\console\command\queue;

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

use queryyetsimple\console\command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use PHPQueue\Runner;
use PHPQueue\Base;
use queryyetsimple\psr4\psr4;
use queryyetsimple\option\option;
use queryyetsimple\mvc\project;

/**
 * 运行任务
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.11
 * @version 1.0
 */
class work extends command {
    
    /**
     * 命令名字
     *
     * @var string
     */
    protected $strName = 'queue:work';
    
    /**
     * 命令行描述
     *
     * @var string
     */
    protected $strDescription = 'Process the next job on a queue';
    
    /**
     * 响应命令
     *
     * @return void
     */
    public function handle() {
        // 注册处理的队列
        $this->setQueue_ ( $this->argument ( 'connect' ), $this->option ( 'queue' ) );
        
        // 守候进程
        $this->runWorker_ ( $this->argument ( 'connect' ), $this->option ( 'queue' ) );
    }
    
    /**
     * 设置消息队列
     *
     * @param string $strConnect            
     * @param string $strQueue            
     * @return void
     */
    protected function setQueue_($strConnect, $strQueue) {
        $strConnect = '\queryyetsimple\queue\queues\\' . $strConnect;
        if (! class_exists ( $strConnect )) {
            $this->error ( $this->time ( sprintf ( 'connect %s not exits.', $strConnect ) ) );
            return;
        }
        call_user_func_array ( [ 
                $strConnect,
                'setQueue' 
        ], [ 
                $strQueue 
        ] );
    }
    
    /**
     * 守候进程
     *
     * @param string $strConnect            
     * @param string $strQueue            
     * @return void
     */
    protected function runWorker_($strConnect, $strQueue) {
        // 验证运行器是否存在
        $strRunner = '\queryyetsimple\queue\runners\\' . $strConnect;
        if (! class_exists ( $strRunner )) {
            $this->error ( $this->time ( sprintf ( 'runner %s not exits.', $strRunner ) ) );
            return;
        }
        
        $this->info ( $this->time ( sprintf ( '%s is on working.', $strConnect . ':' . $strQueue ) ) );
        
        // 守候进程
        (new $strRunner ())->run ();
    }
    
    /**
     * 返回 QueryPHP
     *
     * @return \queryyetsimple\mvc\project
     */
    private function getQueryPHP_() {
        return project::bootstrap ();
    }
    
    /**
     * 命令参数
     *
     * @return array
     */
    protected function getArguments() {
        return [ 
                [ 
                        'connect',
                        InputArgument::OPTIONAL,
                        'The name of connection.',
                        option::gets ( 'quque\default', 'redis' ) 
                ] 
        ];
    }
    
    /**
     * 命令配置
     *
     * @return array
     */
    protected function getOptions() {
        return [ 
                [ 
                        'queue',
                        null,
                        InputOption::VALUE_OPTIONAL,
                        'The queue to listen on',
                        'default' 
                ] 
        ];
    }
}
