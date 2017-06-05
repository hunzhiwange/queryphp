<?php

/**
 * 默认控制器文件
 */
namespace home\application\controller;

use queryyetsimple\mvc\controller;
use queryyetsimple\mvc\project;
// use queryyetsimple\log\log;
use queryyetsimple\database\database;
use queryyetsimple\stack\queue;
use queryyetsimple\http\request;
use queryyetsimple\log\log;
use queryyetsimple\pipeline\pipeline;
use queryyetsimple\rss\rss;
use queryyetsimple\http\response;
use queryyetsimple\cache\filecache;
use queryyetsimple\cache\memcache;
use queryyetsimple\cache\cache;

class index extends controller {
    public function __construct() {
        
    }
    
    /**
     * 默认方法
     *
     * @return void
     */
    public function index() {
        //dump(database::tables('test')->getAll());
        
        $str = (array)'hello';
        print_r($str);
        
        echo __('sdff%sfff',2);
        
        exit ();
    }
}
