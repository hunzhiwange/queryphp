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

namespace admin\app\service\user;

use queryyetsimple\bootstrap\auth\login;

/**
 * 锁屏.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.06
 *
 * @version 1.0
 */
class lock
{
    use login;

    /**
     * 响应方法.
     *
     * @return array|\queryyetsimple\http\response
     */
    public function run()
    {
        $this->lock();

        return ['message' => __('锁屏成功')];
    }
}
