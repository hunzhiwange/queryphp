<?php

/**
 * 默认控制器文件
 */
namespace home\application\controller;

use queryyetsimple\mvc\controller;
use queryyetsimple\response;
use queryyetsimple\view;
use queryyetsimple\database;
use queryyetsimple\http\request;
use queryyetsimple\session;

class index extends controller {
    
    //public function __construct($what){
       // dump($what);
   // }
    
    /**
     * 默认方法
     *
     * @return void
     */
    public function index() {
        
        //exit('sdfsdf');
       // return response::make(['xx'=>55],400,'sdfsdfsdf');
        //return response::api('robots.txt');
        
        //dump(view::assign('xxx','sfsdf')->display('sdfsf'));
        
        //dump(database::table('test')->getAll());
        //dump($_SERVER);
        //request::setGet('ssssss','SDFFFFFFFFF');
        //dump(request::get('ssssss|trim|substr=0,3'));

        //dump(request::gets(['ssssss','t']));
        
       // dump(request::setCookie('ssssss','sdfsdfsdf'));

       // dump(request::cookie('ssssss'));
        
        //session::start();
        
       // dump(request::setSession('ssssss','sdfsdfsdf'));
        
        
        
        //dump(request::session('ssssss'));
        //print_r($_GET);
      // dump(request::url());
      
        print_r(project('request')->url());

        $this->display ();
    }
    
    public function show(){
       // echo $o->method();
       
        print_r(request::method());
        
        echo 'xxx';
    }

    public function yes(request $xx,$what){
        //print_r(request::routerAll());
        var_dump($_GET);
        
        //print_r(func_get_args());
    }
}
