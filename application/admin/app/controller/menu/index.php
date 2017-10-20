<?php
// ©2017 http://your.domain.com All rights reserved.
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
 */
class index extends aaction {
    
    /**
     * 响应方法
     *
     * @param \admin\app\service\menu\index $oService            
     * @return mixed
     */
    public function run(service $oService) {
        return $oService->run ();
    }
}
