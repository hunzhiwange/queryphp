<?php

namespace home\domain\listener;

class test extends abstracts{

    public function run(){
        //print_r(func_get_args());
       // throw new RuntimeException(sprintf('Observer %s must has run method',get_class($this)));
       echo '新建中';
    }

}