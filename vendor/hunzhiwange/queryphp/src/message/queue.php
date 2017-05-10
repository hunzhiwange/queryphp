<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\message;

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

use Q\traits\dynamic\expansion as dynamic_expansion;
//use ;

/**
 * 消息队列
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.09
 * @version 1.0
 */
class queue {
    
    use dynamic_expansion;
    
    protected static $objDrive = null;
    
    /**
     * 配置
     *
     * @var array
     */
    protected $arrInitExpansionInstanceArgs = [
            'drive' => 'redis'
    ];
    
    
    
    public function hello(){
        echo 'xx';
    }
    public static function hello2(){
        echo 'xx';
    }
    
   
    
    /**
     * Create a new job and save it to the specified queue.
     *    
     * @param string $class The name of the class that contains the code to execute the job.
     * @param string $queue The name of the queue to place the job in.
     * @param array $args Any optional arguments that should be passed when the job is executed.
     * @param boolean $trackStatus Set to true to be able to monitor the status of a job.
     *
     * @return string
     */
    public function dispatch($class, $queue = 'default', $args = null, $trackStatus = false){
      //  print_r(func_get_args());
        $strDrive = $this->getDrive();
        
        // 初始化
        if(is_callable([$strDrive, 'init'])){
            call_user_func_array([$strDrive, 'init'], []);
        }
        
        return call_user_func_array([$strDrive, 'dispatch'], func_get_args());
    }
    
    public function getDrive(){

        if()
        
        return 'Q\message\\'.$this->getExpansionInstanceArgs_('drive').'_queue';
    }
    


}
