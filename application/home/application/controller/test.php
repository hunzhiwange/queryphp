<?php

/**
 * 默认控制器文件
 */
namespace home\application\controller;

use Q\mvc\controller;
use Q\option\option;

class test extends controller {
    
    public static function test(){
        
        echo 'hello testsets';
        
    print_r(option::gets('~apps~'));
    }
    
}
