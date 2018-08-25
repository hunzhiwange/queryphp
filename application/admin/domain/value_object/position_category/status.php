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

namespace admin\domain\value_object\position_category;

use queryyetsimple\mvc\value_object;

/**
 * 职位分类状态值对象
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.19
 *
 * @version 1.0
 */
class status extends value_object
{
    /**
     * 构造函数.
     */
    public function __construct()
    {
        parent::__construct(['enable' => __('启用'), 'disable' => __('禁用')]);
    }
}
