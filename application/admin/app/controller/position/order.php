<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\controller\position;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\domain\service\admin_position\order_failed;
use admin\domain\service\admin_position\order as service;

/**
 * 后台职位排序更新
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class order extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\domain\service\admin_position\order $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $mixResult = $oService->run($this->id(), $this->type());
            return [
                    'message' => '职位排序成功'
            ];
        } catch (order_failed $oE) {
            return [
                    'code' => 400,
                    'message' => $oE->getMessage()
            ];
        }
    }

    /**
     * 排序类型
     *
     * @return string
     */
    protected function type()
    {
        return trim(request::all('type'));
    }

    /**
     * 排序作用 ID
     *
     * @return int
     */
    protected function id()
    {
        return intval(request::all('args\0'));
    }
}
