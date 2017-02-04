<?php

namespace home\controller;

use Q\mvc\controller;

class topic extends controller {
    
    /**
     * 默认方法
     */
    public function index() {
        print_r($_GET);
        
        exit();
        //
        $this->display ();
    }
    
    public function show() {
        print_r($_GET);
    }
    
}
