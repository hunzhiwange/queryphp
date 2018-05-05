<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace home\app\controller;

use queryyetsimple\mvc\controller;

/**
 * v8 控制器
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2018.01.10
 * @version 1.0
 */
class v8 extends controller
{    
    
    /**
     * vue 演示
     *
     * @return void
     */
    public function index()
    {
        $this->assign('msg', 'hello world');

        return $this->

        switchView(app('v8'))->

        display();
    }

    /**
     * art 演示
     *
     * @return void
     */
    public function art()
    {
        $this->assign('list', [
            '摄影', 
            '电影', 
            '民谣', 
            '旅行', 
            '吉他'
        ]);

        return $this->

        switchView(app('v8'))->

        display();
    }

    /**
     * require 演示
     *
     * @return void
     */
    public function requires()
    {
        return $this->

        switchView(app('v8'))->

        display();
    }
}
