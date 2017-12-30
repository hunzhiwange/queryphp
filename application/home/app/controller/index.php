<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace home\app\controller;

//use queryyetsimple\mvc\controller;
use queryyetsimple\db;
use qys\mvc\controller;
use qys\option;

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
function gen() {
    $ret = (yield 'yield1');
    var_dump($ret);
    $ret = (yield 'yield2');
    var_dump($ret);
}

$gen = gen();
var_dump($gen->current()); 
 
var_dump($gen->send('ret1'));var_dump($gen->current()); var_dump($gen->current()); var_dump($gen->current()); 
        exit();
    }

    public function test2(){
        return 'lm';
    }
}
