<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\controller\menus;

use Exception;
use queryyetsimple\response;
use admin\app\controller\aaction;
use admin\app\service\menus\index as service;

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
     * @param \admin\app\service\menus\index $oService    
     * @return mixed
     */
    public function run(service $oService) {
        try {
            return $oService->run ();
        } catch ( Exception $oE ) {
            return response::apiError ( $oE->getMessage () );
        }
    }
}
