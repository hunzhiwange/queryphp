<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\position_category;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\position_category\index as service;

/**
 * 后台职位分类列表
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.18
 * @version 1.0
 * @menu
 * @title 列表
 * @name
 * @path
 * @component
 * @icon
 */
class index extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\position_category\index $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        return $oService->run($this->search());
    }


    /**
     * search 数据
     *
     * @return array
     */
    protected function search()
    {
        return request::gets([
                'key|trim'
        ]);
    }
}
