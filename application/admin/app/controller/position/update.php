<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\controller\position;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\position\update_failed;
use admin\app\service\position\update as service;

/**
 * 后台职位编辑更新
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
     * @param \admin\app\service\position\update $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $mixResult = $oService->run($this->data());
            return [
                    'message' => '职位更新成功'
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
