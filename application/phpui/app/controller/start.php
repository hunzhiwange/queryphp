<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace phpui\app\controller;

use queryyetsimple\mvc\controller;

/**
 * phpui start 控制器
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.21
 * @version 1.0
 */
class start extends controller
{

    /**
     * 默认方法
     *
     * @return void
     */
    public function index()
    {
        $this->assign('strHelloworld', 'Say hello to phpui');
        return $this->display();
    }
}
