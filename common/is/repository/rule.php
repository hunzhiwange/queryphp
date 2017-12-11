<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\is\repository;

use queryyetsimple\mvc\repository;
use common\domain\entity\rule as aggregate;
use common\domain\repository\rule as rule_repository;

/**
 * 权限仓储实现
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.11
 * @version 1.0
 */
class rule extends repository implements rule_repository
{

    /**
     * 权限聚合根
     *
     * @var \common\domain\entity\rule
     */
    protected $oAggregate;

    /**
     * 构造函数
     *
     * @param \common\domain\entity\rule $objAggregate
     * @return void
     */
    public function __construct(aggregate $objAggregate)
    {
        parent::__construct($objAggregate);
    }
}
