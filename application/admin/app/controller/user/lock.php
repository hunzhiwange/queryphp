<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\user;

use admin\app\controller\aaction;
use admin\app\service\user\lock as service;

/**
 * 锁屏操作
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.06
 * @version 1.0
 */
class lock extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\user\lock $oService
     * @return array
     */
    public function run(service $oService)
    {
        return $oService->run();
    }
}
