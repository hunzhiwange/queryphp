<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace admin\app\controller;

use common\app\controller\acontroller as acontrollers;
use queryyetsimple\auth;
use queryyetsimple\request;

/**
 * admin 基础控制器.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
abstract class acontroller extends acontrollers
{
    /**
     * 登录信息.
     *
     * @var array
     */
    protected $arrLogin = [];

    /**
     * 构造函数.
     */
    public function __construct()
    {
        parent::__construct();

        // 强制设置为 ajax
        set_ajax_request();

        // 验证登录状态
        $strApiToken = request::header('authKey');
        if (empty($strApiToken) || (auth::setTokenName($strApiToken) && !($this->arrLogin = auth::getLogin()))) {
            exit(json_encode([
                'code'  => 101,
                'error' => __('登录已失效'),
            ], JSON_UNESCAPED_UNICODE));
        }

        // 验证是否锁屏
        if (auth::isLock() && !in_array($this->requestNode(), $this->ignoreLock(), true)) {
            exit(json_encode([
                'code'  => 102,
                'error' => __('屏幕已锁定'),
            ], JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * 获取登录信息.
     *
     * @return array
     */
    public function login()
    {
        return $this->arrLogin;
    }

    /**
     * 访问节点.
     *
     * @return string
     */
    protected function requestNode()
    {
        return request::controller().'/'.request::action();
    }

    /**
     * 锁定忽略操作.
     *
     * @return array
     */
    protected function ignoreLock()
    {
        return [
            'user/unlock',
            'user/logout',
        ];
    }
}
