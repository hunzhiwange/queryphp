<?php

/**
 * 默认控制器文件
 */
namespace home\application\controller;

use Q\mvc\controller;
use Resque;
use Q\message\queue;

class index extends controller {
    
    // public function __construct(test_provider $test ){
    // print_r($test);
    // }
    
    /**
     * 默认方法
     *
     * @return void
     */
    public function index() {
        
        //if(empty($argv[1])) {
         //   die('Specify the name of a job to add. e.g, php queue.php PHP_Job');
        //}
        
       // require './../lib/Resque.php';
       // date_default_timezone_set('GMT');
//         Resque::setBackend('127.0.0.1:6379');
        
        $args = array(
                'time' => time(),
                'array' => array(
                        'test' => 'test',
                ),
        );
        
//         $jobId = Resque::enqueue('default', 'PHP_Job', $args, true);
//         echo "Queued job ".$jobId."\n\n";
        
       $jobId= queue::dispatchs('PHP_Job','default', $args, true);
       echo "\n\n"."Queued job ".$jobId."\n\n";
       // echo 'Hello world';
        //throw new \BadFunctionCallException('sdf');
        //$this->display();
        exit();
    }
}
