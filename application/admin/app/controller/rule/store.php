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

namespace admin\app\controller\rule;

use admin\app\controller\aaction;
use admin\app\service\rule\store as service;
use queryyetsimple\request;

/**
 * 后台权限新增保存.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.11
 *
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
     * 响应方法.
     *
     * @param \admin\app\service\rule\store $oService
     *
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
     * POST 数据.
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
            'value',
        ]);
    }
}
