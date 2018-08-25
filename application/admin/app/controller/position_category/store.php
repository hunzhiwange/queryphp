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

namespace admin\app\controller\position_category;

use admin\app\controller\aaction;
use admin\app\service\position_category\store as service;
use admin\domain\value_object\position_category\status;
use queryyetsimple\request;

/**
 * 后台职位分类新增保存.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.19
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
     * 职位分类状态值对象
     *
     * @var \admin\domain\value_object\position_category\status
     */
    protected $oStatus;

    /**
     * 响应方法.
     *
     * @param \admin\app\service\position_category\store          $oService
     * @param \admin\domain\value_object\position_category\status $oStatus
     *
     * @return mixed
     */
    public function run(service $oService, status $oStatus)
    {
        $this->oStatus = $oStatus;

        $mixResult = $oService->run($this->data());
        $mixResult = $mixResult->toArray();
        $mixResult['status_name'] = $this->statusName($mixResult['status']);
        $mixResult['message'] = __('职位分类保存成功');

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
            'name|trim',
            'remark|trim',
            'status',
        ]);
    }

    /**
     * 状态名字.
     *
     * @param string $strStatus
     *
     * @return string
     */
    protected function statusName($strStatus)
    {
        return $this->oStatus->{$strStatus};
    }
}
