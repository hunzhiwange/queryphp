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
use admin\app\service\user\change_password as service;
use queryyetsimple\request;

/**
 * 修改用户登录密码
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.21
 *
 * @version 1.0
 */
class change_password extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\app\service\user\changePassword $oService
     *
     * @return array|\queryyetsimple\http\response
     */
    public function run(service $oService)
    {
        return $oService->run($this->id(), $this->data());
    }

    /**
     * POST 数据.
     *
     * @return array
     */
    protected function data()
    {
        return request::alls([
            'old_pwd|trim',
            'new_pwd|trim',
            'confirm_pwd|trim',
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
