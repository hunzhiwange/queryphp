<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\controller\base;

use admin\is\verify\image;
use admin\app\controller\aaction;

/**
 * 验证码
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class getVerify extends aaction {
    
    /**
     * 响应方法
     *
     * @param \admin\is\verify\image $oImage            
     * @return mixed
     */
    public function run(image $oImage) {
        return $oImage->run ();
    }
}
