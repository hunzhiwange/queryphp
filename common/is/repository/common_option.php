<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\is\repository;

use queryyetsimple\mvc\repository;
use common\domain\entity\common_option as aggregate;
use common\domain\repository\common_option as common_option_repository;

/**
 * 公共配置（聚合根）实现
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class common_option extends repository implements common_option_repository
{

    /**
     * 后台菜单聚合根
     *
     * @var \common\domain\entity\common_option
     */
    protected $oAggregate;

    /**
     * 构造函数
     *
     * @param \common\domain\entity\common_option $objAggregate
     * @return void
     */
    public function __construct(aggregate $objAggregate)
    {
        parent::__construct($objAggregate);
    }
}
