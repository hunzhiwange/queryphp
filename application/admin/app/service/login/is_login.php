<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\login;

use queryyetsimple\bootstrap\auth\login;

/**
 * 验证是否登录
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.22
 * @version 1.0
 */
class is_login
{
    use login;

    /**
     * 响应方法
     *
     * @return boolean
     */
    public function run()
    {
        return $this->isLogin();
    }
}
