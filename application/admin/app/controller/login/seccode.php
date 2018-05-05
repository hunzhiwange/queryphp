<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\login;

use admin\app\controller\aaction;
use admin\is\seccode\seccode as seccodes;

/**
 * 验证码
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class seccode extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\is\seccode\seccode $oSeccode
     * @return mixed
     */
    public function run(seccodes $oSeccode)
    {
        return $oSeccode->make();
    }
}
