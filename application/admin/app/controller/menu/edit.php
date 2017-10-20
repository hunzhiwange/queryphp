<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\controller\menu;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\menu\edit as service;

/**
 * 后台菜单编辑
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class edit extends aaction {
    
    /**
     * 响应方法
     *
     * @param \admin\app\service\menu\edit $oService            
     * @return mixed
     */
    public function run(service $oService) {
        return $oService->run ( $this->id () );
    }
    
    /**
     * 编辑 ID
     *
     * @return int
     */
    protected function id(){
        return intval(request::all('args\0'));
    }
}