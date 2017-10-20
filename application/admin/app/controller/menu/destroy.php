<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\controller\menu;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\menu\destroy_failed;
use admin\app\service\menu\destroy as service;

/**
 * 后台菜单删除
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class destroy extends aaction {
    
    /**
     * 响应方法
     *
     * @param \admin\app\service\menu\destroy $oService            
     * @return mixed
     */
    public function run(service $oService) {
        try {
            $mixResult = $oService->run ( $this->id () );
            return [ 
                    'message' => '菜单删除成功' 
            ];
        } catch ( destroy_failed $oE ) {
            return [ 
                    'code' => 400,
                    'message' => $oE->getMessage () 
            ];
        }
    }
    
    /**
     * 删除 ID
     *
     * @return int
     */
    protected function id() {
        return intval ( request::all ( 'args\0' ) );
    }
}
