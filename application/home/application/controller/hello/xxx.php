<?php

namespace home\application\controller\hello;

use queryyetsimple\mvc\action;

class xxx extends action {

    /**
     * 执行入口
     */
    public function run($that = null, $in = []) {
        echo 'hello world';
    }

}