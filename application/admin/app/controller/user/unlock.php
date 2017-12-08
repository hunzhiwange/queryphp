<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\user;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\user\unlock_failed;
use admin\app\service\user\unlock as service;

/**
 * 解锁密码验证
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.06
 * @version 1.0
 */
class unlock extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\user\unlock $oService
     * @return array
     */
    public function run(service $oService)
    {
        return $oService->run($this->name(), $this->password());
    }

    /**
     * POST 密码数据
     *
     * @return string
     */
    protected function password()
    {
        return request::all('password|trim');
    }

    /**
     * 登录用户数据
     *
     * @return string
     */
    protected function name()
    {
        return $this->objController->login()['name'];
    }
}
