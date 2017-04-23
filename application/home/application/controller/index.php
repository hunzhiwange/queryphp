<?php

/**
 * 默认控制器文件
 */
namespace home\application\controller;

use Q\mvc\controller;

class index extends controller {
    /**
     * 默认方法
     */
    public function index() {
        $this->display ();
    }
}
