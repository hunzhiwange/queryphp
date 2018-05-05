<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\user;

use admin\app\controller\aaction;
use admin\app\service\user\logout as service;

/**
 * 退出登录状态
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.23
 * @version 1.0
 */
class logout extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\user\logout $oService
     * @return array
     */
    public function run(service $oService)
    {
        return $oService->run();
    }
}
