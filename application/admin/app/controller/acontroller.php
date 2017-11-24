<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller;

use queryyetsimple\auth;
use queryyetsimple\request;
use common\app\controller\acontroller as acontrollers;

/**
 * admin 基础控制器
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
abstract class acontroller extends acontrollers
{

    /**
     * 登录信息
     *
     * @var array
     */
    protected $arrLogin = [];

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

        // 验证登录状态
        $strApiToken = request::header('authKey');
        if (empty($strApiToken) || (auth::setTokenName($strApiToken) && ! ($this->arrLogin = auth::getLogin()))) {
            exit(json_encode([
                'code' => 101,
                'error' => '登录已失效'
            ], JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * 获取登录信息
     *
     * @return  array
     */
    public function login()
    {
        return $this->arrLogin;
    }
}
