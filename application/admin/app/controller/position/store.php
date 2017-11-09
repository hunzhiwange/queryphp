<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\controller\position;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\position\store as service;

/**
 * 后台职位新增保存
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class store extends aaction {
    
    /**
     * 响应方法
     *
     * @param \admin\app\service\position\store $oService            
     * @return mixed
     */
    public function run(service $oService) {
        $mixResult = $oService->run ( $this->data () );
        return [ 
                'message' => '职位保存成功' 
        ];
    }
    
    /**
     * POST 数据
     *
     * @return array
     */
    protected function data() {
        return request::alls ( [ 
                'name|trim',
                'pid'
        ] );
    }
}