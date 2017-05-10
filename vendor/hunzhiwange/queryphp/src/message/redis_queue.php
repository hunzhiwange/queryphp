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

use Resque;

/**
 * 消息队列
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.09
 * @version 1.0
 */
class redis_queue extends Resque {
    
    protected $strType = 'redis';
    
    public function __construct(){
      // echo '123';
        static::setBackend('127.0.0.1:6379');
        //echo 'xxx';
    }
    
    public function getType(){
        return $this->strType;
    }
    
    /**
     * 返回一个 redis 存储器
     *
     * @return Resque_Redis Instance of Resque_Redis.
     */
    public function storage()
    {
        return static::redis();
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
  
        return static::enqueue($queue, $class,$args,$trackStatus);
    }
    
    /**
     * Create a new job and save it to the specified queue.
     *
     * @param string $queue The name of the queue to place the job in.
     * @param string $class The name of the class that contains the code to execute the job.
     * @param array $args Any optional arguments that should be passed when the job is executed.
     * @param boolean $trackStatus Set to true to be able to monitor the status of a job.
     *
     * @return string
     */
    public static function enqueue($queue, $class, $args = null, $trackStatus = false)
    {
        $result = redis_job::create($queue, $class, $args, $trackStatus);
        if ($result) {
            event::trigger('afterEnqueue', [
            'class' => $class,
            'args'  => $args,
            'queue' => $queue,
            ]);
        }
    
        return $result;
    }
    
    /**
     * Push a job to the end of a specific queue. If the queue does not
     * exist, then create it as well.
     *
     * @param string $queue The name of the queue to add the job to.
     * @param array $item Job description as an array to be JSON encoded.
     */
    public static function push($queue, $item)
    {
        self::redis()->sadd('queues', $queue);
        self::redis()->rpush('queue:' . $queue, json_encode($item));
    }
    
    //public function push(){
        
    //}
}
