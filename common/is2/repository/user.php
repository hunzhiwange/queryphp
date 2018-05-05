<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\is\repository;

use queryyetsimple\mvc\repository;
use common\domain\entity\user as aggregate;
use common\domain\repository\user as user_repository;

/**
 * 用户帐号（聚合根）实现
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.12
 * @version 1.0
 */
class user extends repository implements user_repository
{

    /**
     * 后台菜单聚合根
     *
     * @var \common\domain\entity\user
     */
    protected $oAggregate;

    /**
     * 构造函数
     *
     * @param \common\domain\entity\user $objAggregate
     * @return void
     */
    public function __construct(aggregate $objAggregate)
    {
        parent::__construct($objAggregate);
    }
}
