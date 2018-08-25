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

namespace admin\app\controller\position;

use admin\app\controller\aaction;
use admin\app\service\position\enable as service;
use queryyetsimple\request;

/**
 * 后台职位状态更新.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class enable extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\app\service\position\enable $oService
     *
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $mixResult = $oService->run($this->id(), $this->status());

            return [
                'message' => '职位状态更新成功',
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
}
