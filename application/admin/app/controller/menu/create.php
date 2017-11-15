<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\controller\menu;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\menu\create as service;

/**
 * 后台菜单新增
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class create extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\menu\create $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        return $oService->run($this->parentId());
    }

    /**
     * 父级 ID
     *
     * @return int
     */
    protected function parentId()
    {
        return request::all('pid|intval');
    }
}
