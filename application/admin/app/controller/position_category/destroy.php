<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\position_category;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\position_category\destroy_failed;
use admin\app\service\position_category\destroy as service;

/**
 * 后台职位分类删除
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.19
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
     * @param \admin\app\service\position_category\destroy $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $mixResult = $oService->run($this->id());
            return [
                'message' => __('职位分类删除成功')
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
