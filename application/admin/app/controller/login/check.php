<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\login;

use admin\is\seccode\code;
use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\login\check as service;

/**
 * 验证登录
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.22
 * @version 1.0
 */
class check extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\login\check $oService
     * @param \admin\is\seccode\code $oCode
     * @return array
     */
    public function run(service $oService, code $oCode)
    {
        return $oService->run($this->data(), $this->code($oCode));
    }

    /**
     * 验证码数据
     *
     * @param \admin\is\seccode\code $oCode
     * @return string
     */
    protected function code(code $oCode)
    {
        return $oCode->get();
    }

    /**
     * POST 数据
     *
     * @return array
     */
    protected function data()
    {
        return request::alls([
            'seccode|trim',
            'name|trim',
            'password|trim',
            'remember_me|intval'
        ]);
    }
}
