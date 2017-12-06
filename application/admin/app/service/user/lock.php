<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\user;

use queryyetsimple\bootstrap\auth\login;

/**
 * 锁屏
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.06
 * @version 1.0
 */
class lock
{
    use login;

    /**
     * 响应方法
     *
     * @return \queryyetsimple\http\response|array
     */
    public function run()
    {
        $this->lock();
        return ['message' => __('锁屏成功')];
    }
}
