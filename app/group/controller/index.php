<?php

namespace home\controller;

use Q, Q\mvc\controller;

class index extends controller {
    
    /**
     * 默认方法
     */
    public function index() {
        //
        $this->display ();
    }
    
    public function test() {
        var_dump($_GET);
    }
    
}
