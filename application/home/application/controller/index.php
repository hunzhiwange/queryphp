<?php

/**
 * 默认控制器文件
 */
namespace home\application\controller;

use queryyetsimple\mvc\controller;
use queryyetsimple\log\log;
use queryyetsimple\database\database;
use queryyetsimple\stack\queue;

class index extends controller {
    
     public function __construct( $str,$test = [1,2],$hello=55 ){
      //  print_r($test);
        
       // print_r(func_get_args());
     }
    
    /**
     * 默认方法
     *
     * @return void
     */
    public function index() {
        //echo 'xx';
        
       // $objStack = new queue('array');
        
      //  $objStack->in('11');
       // $objStack->dequeue();
       
       // $dotenv = new \Dotenv\Dotenv(PATH);
       // $dotenv->load();
        
        
       echo env('APP_DEBUG');
        
//print_r($_ENV);
        //dump(database::connects()->table('test')->getAll());
        //dump(database::connects()->table('test')->getAll());
        //exit();
       // var_dump(project()->);
       
       // project('event');
        
        //var_dump(project('option')->get('default_app2'));
        //var_dump(project()->make ('log'));
        //echo 'xx';
       // log::runs('xx');
        
        //exit();
        $this->display();
        exit();
    }
}
