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

namespace admin\is\seccode;

use queryyetsimple\cache;
use queryyetsimple\seccode\seccode as seccodes;

/**
 * 验证码生成器.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class seccode
{
    /**
     * 验证码生成器.
     *
     * @var \queryyetsimple\seccode\seccode
     */
    protected $oSeccode;

    /**
     * 构造函数.
     *
     * @param \queryyetsimple\seccode\seccode $oSeccode
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
            'width'  => 120,
            'height' => 36,
        ])->display(4, true);

        cache::set('admin_seccode', $this->oSeccode->getCode());

        exit();
    }
}
