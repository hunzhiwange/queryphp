<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller;

use queryyetsimple\option;
use queryyetsimple\request;
use common\app\controller\acontroller as acontrollers;

/**
 * 基础控制器
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class base extends acontrollers
{

    /**
     * 构造函数
     *
     * @return  void
     */
    public function __construct()
    {
        parent::__construct();

        // 强制设置为 ajax
        set_ajax_request();
    }
}
