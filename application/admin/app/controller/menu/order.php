<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\controller\menu;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\domain\service\admin_menu\order_failed;
use admin\domain\service\admin_menu\order as service;

/**
 * 后台菜单排序更新
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class order extends aaction {
    
    /**
     * 响应方法
     *
     * @param \admin\domain\service\admin_menu\order $oService            
     * @return mixed
     */
    public function run(service $oService) {
        try {
            $mixResult = $oService->run ( $this->id (), $this->type () );
            return [ 
                    'message' => '菜单排序成功' 
            ];
        } catch ( order_failed $oE ) {
            return [ 
                    'code' => 400,
                    'message' => $oE->getMessage () 
            ];
        }
    }
    
    /**
     * 排序类型
     *
     * @return string
     */
    protected function type() {
        return trim ( request::all ( 'type' ) );
    }

    /**
     * 排序作用 ID
     * 
     * @return int
     */
    protected function id(){
        return intval(request::all('args\0'));
    }
}
