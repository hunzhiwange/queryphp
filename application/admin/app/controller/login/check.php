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
use admin\app\service\login\check as service;
use admin\is\seccode\code;
use queryyetsimple\request;

/**
 * 验证登录.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.22
 *
 * @version 1.0
 */
class check extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\app\service\login\check $oService
     * @param \admin\is\seccode\code         $oCode
     *
     * @return array
     */
    public function run(service $oService, code $oCode)
    {
        return $oService->run($this->data(), $this->code($oCode));
    }

    /**
     * 验证码数据.
     *
     * @param \admin\is\seccode\code $oCode
     *
     * @return string
     */
    protected function code(code $oCode)
    {
        return $oCode->get();
    }

    /**
     * POST 数据.
     *
     * @return array
     */
    protected function data()
    {
        return request::alls([
            'seccode|trim',
            'name|trim',
            'password|trim',
            'remember_me|intval',
        ]);
    }
}
