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

namespace admin\app\controller\systemConfigs;

use admin\app\controller\aaction;
use common\domain\service\common_option\update as service;
use queryyetsimple\request;

/**
 * 后台配置信息更新保存.
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
     * @param \common\domain\service\common_option\update $oService
     *
     * @return mixed
     */
    public function run(service $oService)
    {
        $mixResult = $oService->run($this->data());

        return [
            'message' => '配置更新成功',
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
            'SYSTEM_NAME|trim',
            'IDENTIFYING_CODE|intval',
            'LOGO_TYPE|intval',
            'LOGIN_SESSION_VALID|intval',
            'SYSTEM_LOGO|trim',
        ]);
    }
}
