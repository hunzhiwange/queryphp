<?php

/**
 * 默认控制器文件
 */
namespace home\application\controller;

use queryyetsimple\mvc\controller;
use queryyetsimple\filesystem;
//use queryyetsimple\sessio;
use queryyetsimple\request;
use queryyetsimple\response;

class index extends controller {
    public function __construct() {
    }
    
    /**
     * 默认方法
     *
     * @return void
     */
    public function index() {
        $oLog = project('log');
        
        dump($oLog);
        
        $oLog->record('xx');
        $oLog->record('xx','error');
        $oLog->record('xx'); 
        $oLog->record('xx');
        
        $oLog->save();
        $oLog->write('222');
        $this->display();
    }
}
