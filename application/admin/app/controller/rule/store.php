<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\rule;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\rule\store as service;

/**
 * 后台权限新增保存
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.11
 * @version 1.0
 * @menu
 * @title 保存
 * @name
 * @path
 * @component
 * @icon
 */
class store extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\rule\store $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        $mixResult = $oService->run($this->data());
        $mixResult = $mixResult->toArray();
        $mixResult['message'] = __('权限保存成功');
        return $mixResult;
    }

    /**
     * POST 数据
     *
     * @return array
     */
    protected function data()
    {
        return request::alls([
            'pid',
            'title|trim',
            'name|trim',
            'status',
            'app|trim',
            'type|trim',
            'value'
        ]);
    }
}
