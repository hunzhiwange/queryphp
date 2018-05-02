<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\app\controller;

use queryyetsimple\mvc\action;

/**
 * 基础方法器
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class aaction extends action
{

    /**
     * IOC 容器调用回调实现依赖注入
     *
     * @param  calable $calClass
     * @param  array  $arrArgs
     * @return mixed
     */
    public function call($calClass, array $arrArgs = [])
    {
        return $this->objController->call($calClass, $arrArgs);
    }
}
