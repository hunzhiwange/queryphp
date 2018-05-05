<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\position;

use admin\app\controller\aaction;
use admin\domain\entity\admin_position;
use admin\app\service\position\index as service;
use queryyetsimple\db;

/**
 * 后台职位列表
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class index extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\position\index $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        print_r(admin_position::paginate(5));
        exit();
        return $oService->run();
    }
}
