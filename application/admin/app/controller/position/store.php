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
use admin\app\service\position\store as service;
use queryyetsimple\request;

/**
 * 后台职位新增保存.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class store extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\app\service\position\store $oService
     *
     * @return mixed
     */
    public function run(service $oService)
    {
        $mixResult = $oService->run($this->data());

        return [
            'message' => '职位保存成功',
        ];
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
            'pid',
        ]);
    }
}
