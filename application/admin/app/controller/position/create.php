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
use admin\app\service\position\create as service;
use queryyetsimple\request;

/**
 * 后台职位新增.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class create extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\app\service\position\create $oService
     *
     * @return mixed
     */
    public function run(service $oService)
    {
        return $oService->run($this->parentId());
    }

    /**
     * 父级 ID.
     *
     * @return int
     */
    protected function parentId()
    {
        return request::all('pid|intval');
    }
}
