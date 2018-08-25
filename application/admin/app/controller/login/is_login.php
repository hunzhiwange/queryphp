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

namespace admin\app\controller\login;

use admin\app\controller\aaction;
use admin\app\service\login\is_login as service;

/**
 * 验证是否已经登录.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.22
 *
 * @version 1.0
 */
class is_login extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\app\service\login\is_login $oService
     *
     * @return array
     */
    public function run(service $oService)
    {
        $booResult = $oService->run();
        if ($booResult) {
            return [
                'message' => '用户处于登录状态',
            ];
        }

        return [
            'code'    => 400,
            'message' => '用户尚未登录',
        ];
    }
}
