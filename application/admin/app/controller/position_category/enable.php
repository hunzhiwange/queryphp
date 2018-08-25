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

namespace admin\app\controller\structure;

use admin\app\controller\aaction;
use admin\app\service\structure\enable as service;
use queryyetsimple\request;

/**
 * 后台部门状态更新.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 * @menu
 * @title 启用禁用
 * @name
 * @path
 * @component
 * @icon
 */
class enable extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\app\service\structure\enable $oService
     *
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $strStatus = $this->status();
            $mixResult = $oService->run($this->id(), $strStatus);

            return [
                'message' => __('部门状态%s成功', $this->messageType($strStatus)),
            ];
        } catch (update_failed $oE) {
            return [
                'code'    => 400,
                'message' => $oE->getMessage(),
            ];
        }
    }

    /**
     * 启用禁用状态
     *
     * @return string
     */
    protected function status()
    {
        return trim(request::all('status'));
    }

    /**
     * ID 数据.
     *
     * @return int
     */
    protected function id()
    {
        return request::all('args\0');
    }

    /**
     * 成功消息类型.
     *
     * @param string $strType
     *
     * @return string
     */
    protected function messageType($strType)
    {
        return ['disable' => __('禁用'), 'enable' => __('启用')][$strType];
    }
}
