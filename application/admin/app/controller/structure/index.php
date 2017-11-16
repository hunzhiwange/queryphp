<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\structure;

use admin\app\controller\aaction;
use admin\app\service\structure\index as service;

/**
 * 后台部门列表
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class index extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\structure\index $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        return $oService->run();
    }
}
