<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\user;

use Exception;
use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\user\changePassword as service;

/**
 * 修改用户登录密码
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.21
 * @version 1.0
 */
class changePassword extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\user\changePassword $oService
     * @return \queryyetsimple\http\response|array
     */
    public function run(service $oService)
    {
        return $oService->run($this->id(), $this->data());
    }

    /**
     * POST 数据
     *
     * @return array
     */
    protected function data()
    {
        return request::alls([
            'old_pwd|trim',
            'new_pwd|trim',
            'confirm_pwd|trim'
        ]);
    }

    /**
     * ID 数据
     *
     * @return int
     */
    protected function id()
    {
        return $this->objController->login()['id'];
    }
}
