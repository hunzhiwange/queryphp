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

namespace admin\app\service\login;

use queryyetsimple\bootstrap\auth\login;

/**
 * 验证是否登录.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.22
 *
 * @version 1.0
 */
class is_login
{
    use login;

    /**
     * 响应方法.
     *
     * @return bool
     */
    public function run()
    {
        return $this->isLogin();
    }
}
