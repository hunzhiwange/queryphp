<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\domain\value_object\position_category;

use queryyetsimple\mvc\value_object;

/**
 * 职位分类状态值对象
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.19
 * @version 1.0
 */
class status extends value_object
{

    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(['enable' => __('启用'), 'disable' => __('禁用')]);
    }
}
