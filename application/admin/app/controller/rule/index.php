<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\rule;

use admin\app\controller\aaction;
use admin\app\service\rule\index as service;

/**
 * 后台权限列表
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.11
 * @version 1.0
 * @menu
 * @title 列表
 * @name
 * @path
 * @component
 * @icon
 */
class index extends aaction
{
    
    /**
     * 响应方法
     *
     * @param \admin\app\service\rule\index $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        return $oService->run();
    }
}
