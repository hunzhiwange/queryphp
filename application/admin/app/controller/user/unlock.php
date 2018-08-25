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
use admin\app\service\user\unlock as service;
use queryyetsimple\request;

/**
 * 解锁密码验证
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.06
 *
 * @version 1.0
 */
class unlock extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\app\service\user\unlock $oService
     *
     * @return array
     */
    public function run(service $oService)
    {
        return $oService->run($this->name(), $this->password());
    }

    /**
     * POST 密码数据.
     *
     * @return string
     */
    protected function password()
    {
        return request::all('password|trim');
    }

    /**
     * 登录用户数据.
     *
     * @return string
     */
    protected function name()
    {
        return $this->objController->login()['name'];
    }
}
