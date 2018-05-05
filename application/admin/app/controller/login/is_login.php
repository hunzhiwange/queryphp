<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\login;

use admin\app\controller\aaction;
use admin\app\service\login\is_login as service;

/**
 * 验证是否已经登录
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.22
 * @version 1.0
 */
class is_login extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\login\is_login $oService
     * @return array
     */
    public function run(service $oService)
    {
        $booResult = $oService->run();
        if ($booResult) {
            return [
                'message' => '用户处于登录状态'
            ];
        } else {
            return [
                'code' => 400,
                'message' => '用户尚未登录'
            ];
        }
    }
}
