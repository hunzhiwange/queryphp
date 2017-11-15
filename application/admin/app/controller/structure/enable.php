<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\controller\structure;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\structure\enable_failed;
use admin\app\service\structure\enable as service;

/**
 * 后台部门状态更新
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class enable extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\structure\enable $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $mixResult = $oService->run($this->id(), $this->status());
            return [
                    'message' => '部门状态更新成功'
            ];
        } catch (update_failed $oE) {
            return [
                    'code' => 400,
                    'message' => $oE->getMessage()
            ];
        }
    }

    /**
     * 启用禁用状态
     *
     * @return string
     */
    protected function status()
    {
        return trim(request::all('status'));
    }

    /**
     * ID 数据
     *
     * @return int
     */
    protected function id()
    {
        return request::all('args\0');
    }
}
