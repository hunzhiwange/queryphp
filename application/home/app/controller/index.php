<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace home\app\controller;

use queryyetsimple\mvc\controller;
use queryyetsimple\validate\validate;

/**
 * index 控制器
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class index extends controller
{

    /**
     * 默认方法
     *
     * @return void
     */
    public function index()
    {
        return $this->display();
    }
}
