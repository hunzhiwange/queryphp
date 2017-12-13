<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\rule;

use admin\app\controller\aaction;
use admin\app\service\rule\menu as service;

/**
 * 菜单树结构
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.12
 * @version 1.0
 */
class menu extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\rule\menu $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        return $oService->run();
    }
}