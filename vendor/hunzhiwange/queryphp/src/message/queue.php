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
use Q\message\redis_queue;

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
        $objDrive = $this->getDrive();
        
        job::queue($objDrive);
        status::queue($objDrive);
        
        // 初始化
       // if(is_callable([$strDrive, 'init'])){
            //call_user_func_array([$strDrive, 'init'], []);
        ///}
        
        return call_user_func_array([$objDrive, 'dispatch'], func_get_args());
    }
    
    public function status($strJob){
        $objDrive = $this->getDrive();
        job::queue($objDrive);
        status::queue($objDrive);
        $status = new status($strJob);
        if(!$status->isTracking()) {
            die("Resque is not tracking the status of this job.\n");
        }
        
        var_dump($status->get());
    }
    
    public function work(){
        $objDrive = $this->getDrive();
        job::queue($objDrive);
        status::queue($objDrive);
        worker::queue($objDrive);
        
        $QUEUE = getenv('QUEUE');
        $QUEUE = '*';
        if(empty($QUEUE)) {
            //die("Set QUEUE env var containing the list of queues to work.\n");
        }
        
       // require_once 'lib/Resque.php';
       // require_once 'lib/Resque/Worker.php';
        
       //$REDIS_BACKEND = getenv('REDIS_BACKEND');
       // if(!empty($REDIS_BACKEND)) {
          //  Resque::setBackend($REDIS_BACKEND);
        //}
        
        $logLevel = 0;
        $LOGGING = getenv('LOGGING');
        $VERBOSE = getenv('VERBOSE');
        $VVERBOSE = getenv('VVERBOSE');
        if(!empty($LOGGING) || !empty($VERBOSE)) {
            $logLevel = work::LOG_NORMAL;
        }
        else if(!empty($VVERBOSE)) {
            $logLevel = work::LOG_VERBOSE;
        }
        
        $APP_INCLUDE = getenv('APP_INCLUDE');
        if($APP_INCLUDE) {
            if(!file_exists($APP_INCLUDE)) {
                die('APP_INCLUDE ('.$APP_INCLUDE.") does not exist.\n");
            }
        
            require_once $APP_INCLUDE;
        }
        
        $interval = 5;
        $INTERVAL = getenv('INTERVAL');
        if(!empty($INTERVAL)) {
            $interval = $INTERVAL;
        }
        
        $count = 1;
        $COUNT = getenv('COUNT');
        if(!empty($COUNT) && $COUNT > 1) {
            $count = $COUNT;
        }
        
        if($count > 1) {
            for($i = 0; $i < $count; ++$i) {
                $pid = pcntl_fork();
                if($pid == -1) {
                    die("Could not fork worker ".$i."\n");
                }
                // Child, start the worker
                else if(!$pid) {
                    $queues = explode(',', $QUEUE);
                    $worker = new worker($queues);
                    $worker->logLevel = $logLevel;
                    fwrite(STDOUT, '*** Starting worker '.$worker."\n");
                    $worker->work($interval);
                    break;
                }
            }
        }
        // Start a single worker
        else {
            $queues = explode(',', $QUEUE);
            $worker = new worker($queues);
            $worker->logLevel = $logLevel;
        
            $PIDFILE = getenv('PIDFILE');
            if ($PIDFILE) {
                file_put_contents($PIDFILE, getmypid()) or
                die('Could not write PID information to ' . $PIDFILE);
            }
        
           // fwrite(STDOUT, '*** Starting worker '.$worker."\n");
           echo '*** Starting worker '.$worker;
            $worker->work($interval);
        }
    }
    
    public function getDrive(){

        if(!static::$objDrive){
            $strDrive='Q\message\\'.$this->getExpansionInstanceArgs_('drive').'_queue';
            return static::$objDrive = new $strDrive();
        }
        return static::$objDrive;
    }
    


}
