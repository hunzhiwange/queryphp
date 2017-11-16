<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\structure;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\structure\update_failed;
use admin\app\service\structure\update as service;

/**
 * 后台部门编辑更新
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class update extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\structure\update $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $mixResult = $oService->run($this->data());
            return [
                'message' => '部门更新成功'
            ];
        } catch (update_failed $oE) {
            return [
                'code' => 400,
                'message' => $oE->getMessage()
            ];
        }
    }

    /**
     * POST 数据
     *
     * @return array
     */
    protected function data()
    {
        return request::alls([
                'id|intval',
                'name|trim',
                'pid'
        ]);
    }
}
