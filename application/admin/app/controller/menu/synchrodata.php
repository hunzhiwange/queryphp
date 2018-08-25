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
use admin\app\service\menu\synchrodata as service;
use queryyetsimple\request;

/**
 * 后台菜单数据同步.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.09
 *
 * @version 1.0
 * @menu
 * @title 数据同步
 * @name
 * @path
 * @component
 * @icon
 */
class synchrodata extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\app\service\menu\synchrodata $oService
     *
     * @return mixed
     */
    public function run(service $oService)
    {
        $oService->run($this->replace());

        return ['message' => __('菜单数据同步成功')];
    }

    /**
     * POST 数据.
     *
     * @return bollean
     */
    protected function replace()
    {
        return request::all('replace');
    }
}
