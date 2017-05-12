<?php

/**
 * 默认控制器文件
 */
namespace home\application\controller;

use Q\mvc\controller;
use Q\message\queue;
use home\application\job\my_job;

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
        //$args=[];
//        $jobId = Resque::enqueue('default', 'PHP_Job', $args, true);
//         echo "Queued job ".$jobId."\n\n";
        
     //   queue::statuss('5ee87bdef018c74c8cc9d96aae004766');
        
      //  queue::works();
        
       //$jobId= queue::dispatchs('PHP_Job','default', $args, true);
       //$jobId=queue::dispatchs(new my_job(),'default');
       $jobId2=queue::dispatchs(new my_job(),'default');
       echo "\n\n"."Queued job ".$jobId2."\n\n";
       
        
       // echo 'Hello world';
        //throw new \BadFunctionCallException('sdf');
        //$this->display();
        exit();
    }
}
