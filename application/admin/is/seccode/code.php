<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\is\seccode;

use queryyetsimple\cache;

/**
 * 获取验证码
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.23
 * @version 1.0
 */
class code
{

    /**
     * 获取验证码
     *
     * @return string|false
     */
    public function get()
    {
        return cache::get('admin_seccode');
    }
}
