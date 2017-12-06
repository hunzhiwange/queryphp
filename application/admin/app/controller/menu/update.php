<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\menu;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\menu\update_failed;
use admin\app\service\menu\update as service;

/**
 * 后台菜单编辑更新
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class update extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\menu\update $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $mixResult = $oService->run($this->data());
            return [
                'message' => '菜单更新成功'
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
