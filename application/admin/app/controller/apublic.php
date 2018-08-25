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

namespace admin\app\controller;

use common\app\controller\acontroller as acontrollers;
use queryyetsimple\auth;
use queryyetsimple\request;

/**
 * admin 公共基础控制器.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.22
 *
 * @version 1.0
 */
abstract class apublic extends acontrollers
{
    /**
     * 构造函数.
     */
    public function __construct()
    {
        parent::__construct();

        // 强制设置为 ajax
        set_ajax_request();

        // 设置 apiToken
        $strApiToken = request::header('authKey');
        if (!empty($strApiToken)) {
            auth::setTokenName($strApiToken);
        }
    }
}
