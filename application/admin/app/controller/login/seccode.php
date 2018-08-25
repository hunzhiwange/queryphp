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
use admin\is\seccode\seccode as seccodes;

/**
 * 验证码
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
class seccode extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\is\seccode\seccode $oSeccode
     *
     * @return mixed
     */
    public function run(seccodes $oSeccode)
    {
        return $oSeccode->make();
    }
}
