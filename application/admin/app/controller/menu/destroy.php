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
use admin\app\service\menu\destroy as service;
use admin\app\service\menu\destroy_failed;
use queryyetsimple\request;

/**
 * 后台菜单删除.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 * @menu
 * @title 删除
 * @name
 * @path
 * @component
 * @icon
 */
class destroy extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\app\service\menu\destroy $oService
     *
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $mixResult = $oService->run($this->id());

            return [
                'message' => __('菜单删除成功'),
            ];
        } catch (destroy_failed $oE) {
            return [
                'code'    => 400,
                'message' => $oE->getMessage(),
            ];
        }
    }

    /**
     * 删除 ID.
     *
     * @return int
     */
    protected function id()
    {
        return (int) (request::all('args\0'));
    }
}
