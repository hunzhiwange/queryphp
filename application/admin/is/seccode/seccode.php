<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\is\seccode;

use queryyetsimple\cache;
use queryyetsimple\seccode\seccode as seccodes;

/**
 * 验证码生成器
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class seccode
{

    /**
     * 验证码生成器
     *
     * @var \queryyetsimple\seccode\seccode
     */
    protected $oSeccode;

    /**
     * 构造函数
     *
     * @param \queryyetsimple\seccode\seccode $oSeccode
     * @return void
     */
    public function __construct(seccodes $oSeccode)
    {
        $this->oSeccode = $oSeccode;
    }

    /**
     * 生成验证码
     *
     * @return array
     */
    public function make()
    {
        $this->oSeccode->options([
            'width' => 120,
            'height' => 40
        ])->display(4, true);

        cache::set('admin_seccode', $this->oSeccode->getCode());

        exit();
    }
}
