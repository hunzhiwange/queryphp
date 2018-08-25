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

namespace admin\app\controller\user;

use admin\app\controller\aaction;
use admin\app\service\user\update_info as service;
use admin\app\service\user\update_info_failed;
use queryyetsimple\request;

/**
 * 修改账号信息.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.12
 *
 * @version 1.0
 */
class update_info extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\app\service\user\update_info $oService
     *
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $oService->run($this->id(), $this->data());

            return [
                'message' => '更新账号信息成功',
            ];
        } catch (update_info_failed $oE) {
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
            'nikename|trim',
            'email|trim',
            'mobile|trim',
        ]);
    }

    /**
     * ID 数据.
     *
     * @return int
     */
    protected function id()
    {
        return $this->objController->login()['id'];
    }
}
