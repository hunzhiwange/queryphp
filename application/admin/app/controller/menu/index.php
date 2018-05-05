<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\menu;

use admin\app\controller\aaction;
use admin\app\service\menu\index as service;

/**
 * 后台菜单列表
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
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
     * @param \admin\app\service\menu\index $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        return $oService->run();
    }
}
