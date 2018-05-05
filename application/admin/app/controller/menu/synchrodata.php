<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\menu;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\menu\synchrodata as service;

/**
 * 后台菜单数据同步
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.09
 * @version 1.0
 * @menu
 * @title 数据同步
 * @name
 * @path
 * @component
 * @icon
 */
class synchrodata extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\menu\synchrodata $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        $oService->run($this->replace());
        return ['message' => __('菜单数据同步成功')];
    }

    /**
     * POST 数据
     *
     * @return bollean
     */
    protected function replace()
    {
        return request::all('replace');
    }
}
