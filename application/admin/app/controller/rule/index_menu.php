<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\rule;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\rule\index_menu as service;

/**
 * 首页、菜单合并请求
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.12
 * @version 1.0
 */
class index_menu extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\rule\index_menu $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        return $oService->run($this->data());
    }

    /**
     * POST 数据
     *
     * @return array
     */
    protected function data()
    {
        return request::all('api_multi');
    }
}