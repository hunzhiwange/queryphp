<?php

/**
 * 默认控制器文件
 */
namespace home\application\controller;

use queryyetsimple\mvc\controller;
// use queryyetsimple\mvc\project;
// // use queryyetsimple\log\log;
// use queryyetsimple\database\database;
// use queryyetsimple\stack\queue;
// use queryyetsimple\http\request;
// use queryyetsimple\log\log;
// use queryyetsimple\pipeline\pipeline;
// use queryyetsimple\rss\rss;
// use queryyetsimple\http\response;
// use queryyetsimple\cache\file;
// use queryyetsimple\cache\memcache;
// use queryyetsimple\cache\redis;
// use queryyetsimple\cache;
// use queryyetsimple\session\session;
use queryyetsimple\cookie;
//use qys\cookie;
//use qys\assert;
//use qys\assert\assert;
use qys\cache;
use qys\command;
use queryyetsimple\session;

class test extends command{
}
class index extends controller {
    public function __construct() {
    }
    
    /**
     * 默认方法
     *
     * @return void
     */
    public function index() {
        
        
    //  $sesson =  project('session');
     // dump($sesson);
      
       
       dump($x=session::connect('redis'));
       $x->start();
      //session::set('sdfsdf','sdffffffffff');
      
       $x->set('xx','sdf');
       
     //assert::string(1);
    // dump(session::get('sdfsdf'));
  //// $sesson= $sesson->connect('redis');
    
   // $sesson->start();
    
    //$sesson  = ;
        //log::runs('sdfs','debug');
        
       //cache::set('xx',55,['httponly'=>true]);
        
       // print_r(cache::connect('memcache')->set('xx','xxxx'));
      //  dump(cache::get('xx'));
     // $obj = project();
     //   echo serialize($obj);
      //  exit();
      
       // $arr = [
       //    'hello' => 'world',
       //    'name' => 'ssss'
       // ];
        
       //dump( project()->make('collection',$arr ) );
        
        //dump( collection::faces($arr) );
        //re
        //redis::sets('xxx','22');
        // dump(database::tables('test')->getAll());
        
        // $str = (array)'hello';
        // print_r($str);
        
        // echo __('sdff%sfff',2);
        
        // echo json_encode(1);
        //echo redis::sets ( 'xxx', [ 
        //        'hello' => 'world' 
        //] );
        // redis::deleles('xxx');
       // dump ( redis::gets ( 'xxx' ) );
        // echo redis::sets('xxx',['hello'=>'world']);
       // echo 'x';
        //exit ();
        //new session();
        
      //  $_SESSION['xxx222'] = 'xx';

       // file::sets ( 'dsfd2', '234234' );
       //dump(file::gets ( 'dsfd2' ));
       
        
       // dump ( session::gets ( 'dsfd2' ) ); 
        // dump ( session::gets ( 'dsfd22' ) );
       //  dump($_SESSION);
        //dump ( session::gets ( 'dsfd' ) );
        
        
        
        $this->display();
        //exit ();
    }
}
