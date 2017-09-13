<?php

namespace home\application\controller;

use queryyetsimple\mvc\controller;
use qys\log;
use queryyetsimple\auth\manager;
use qys\auth;
use qys\session;

class index extends controller {

    /**
     * 默认方法
     *
     * @return void
     */
    public function index() {
        return $this->display ();
    }
    
    public function show(){
    }

    public function yes(request $xx,$what){
    }

}
