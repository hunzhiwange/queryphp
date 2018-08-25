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
use admin\domain\service\structure\order as service;
use admin\domain\service\structure\order_failed;
use queryyetsimple\request;

/**
 * 后台部门排序更新.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 * @menu
 * @title 排序
 * @name
 * @path
 * @component
 * @icon
 */
class order extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\domain\service\structure\order $oService
     *
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $strType = $this->type();
            $mixResult = $oService->run($this->id(), $strType);

            return [
                'message' => __('部门%s成功', $this->messageType($strType)),
            ];
        } catch (order_failed $oE) {
            return [
                'code'    => 400,
                'message' => $oE->getMessage(),
            ];
        }
    }

    /**
     * 排序类型.
     *
     * @return string
     */
    protected function type()
    {
        return trim(request::all('type'));
    }

    /**
     * 排序作用 ID.
     *
     * @return int
     */
    protected function id()
    {
        return (int) (request::all('args\0'));
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
        return ['top' => __('置顶'), 'up' => __('上移'), 'down' => __('下移')][$strType];
    }
}
