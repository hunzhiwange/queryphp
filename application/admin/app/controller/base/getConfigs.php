<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\controller\base;

use Exception;
use queryyetsimple\response;
use admin\app\controller\aaction;
use admin\app\service\base\getConfigs as service;

/**
 * 基础配置
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class getConfigs extends aaction {

    /**
     * 响应方法
     * 
     * @param \admin\app\service\base\getConfigs $oService 
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
