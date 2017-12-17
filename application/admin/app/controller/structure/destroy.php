<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\structure;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\structure\destroy_failed;
use admin\app\service\structure\destroy as service;

/**
 * 后台部门删除
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 * @menu
 * @title 删除
 * @name
 * @path
 * @component
 * @icon
 */
class destroy extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\structure\destroy $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $mixResult = $oService->run($this->id());
            return [
                'message' => __('部门删除成功')
            ];
        } catch (destroy_failed $oE) {
            return [
                'code' => 400,
                'message' => $oE->getMessage()
            ];
        }
    }

    /**
     * 删除 ID
     *
     * @return int
     */
    protected function id()
    {
        return intval(request::all('args\0'));
    }
}
