<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace admin\app\controller\menu;

use admin\app\controller\aaction;
use admin\app\service\menu\update as service;
use admin\app\service\menu\update_failed;
use queryyetsimple\request;

/**
 * 后台菜单编辑更新.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 * @menu
 * @title 更新
 * @name
 * @path
 * @component
 * @icon
 */
class update extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\app\service\menu\update $oService
     *
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $mixResult = $oService->run($this->data());

            return [
                'message' => __('菜单更新成功'),
            ];
        } catch (update_failed $oE) {
            return [
                'code'    => 400,
                'message' => $oE->getMessage(),
            ];
        }
    }

    /**
     * POST 数据.
     *
     * @return array
     */
    protected function data()
    {
        return request::alls([
            'id|intval',
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
            'rule|trim',
        ]);
    }
}
