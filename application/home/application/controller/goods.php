<?php

namespace home\application\controller;

use queryyetsimple\mvc\controller;
use queryyetsimple\mvc\interfaces\controller as iiii;

class goods extends controller implements  iiii{
    public function a() {
        echo 'a.';
    }
    public function b() {
        echo 'b.';
        $this->action ( 'a' );
    }
    public function c() {
        echo 'c.';
        $this->action ( 'detail' );
    }
    
    public function detail2(){
        echo 'xx';
    }
}