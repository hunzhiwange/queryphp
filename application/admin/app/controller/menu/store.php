<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\menu;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\menu\store as service;

/**
 * 后台菜单新增保存
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
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
     * @param \admin\app\service\menu\store $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        $mixResult = $oService->run($this->data());
        $mixResult = $mixResult->toArray();
        $mixResult['message'] = __('菜单保存成功');
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
            'path|trim',
            'status',
            'component|trim',
            'icon|trim',
            'app|trim',
            'controller|trim',
            'action|trim',
            'type|trim',
            'siblings|trim',
            'rule|trim'
        ]);
    }
}
