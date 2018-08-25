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
use admin\app\service\position\index as service;
use admin\domain\entity\admin_position;

/**
 * 后台职位列表.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class index extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\app\service\position\index $oService
     *
     * @return mixed
     */
    public function run(service $oService)
    {
        print_r(admin_position::paginate(5));
        exit();

        return $oService->run();
    }
}
