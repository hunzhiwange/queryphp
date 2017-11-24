<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\user;

use queryyetsimple\bootstrap\auth\logout as logouts;

/**
 * 退出登录状态
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.23
 * @version 1.0
 */
class logout
{
    use logouts;

    /**
     * 响应方法
     *
     * @return array
     */
    public function run()
    {
        return $this->logout();
    }
}
