<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller;

use queryyetsimple\auth;
use queryyetsimple\request;
use common\app\controller\acontroller as acontrollers;

/**
 * admin 公共基础控制器
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.22
 * @version 1.0
 */
abstract class apublic extends acontrollers
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

        // 设置 apiToken
        $strApiToken = request::header('authKey');
        if (!empty($strApiToken)) {
            auth::setTokenName($strApiToken);
        }
    }
}
