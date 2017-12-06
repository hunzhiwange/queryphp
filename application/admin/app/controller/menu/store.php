<?php
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
            'menu|trim',
            'module|trim',
            'pid',
            'title|trim',
            'url|trim',
            'status',
            'menu_type|intval',
            'menu_icon|trim'
        ]);
    }
}
