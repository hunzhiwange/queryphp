<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\is\repository;

use queryyetsimple\mvc\repository;
use queryyetsimple\mvc\iaggregate_root;
use admin\domain\entity\admin_position as aggregate;
use admin\domain\repository\admin_position as admin_position_repository;

/**
 * 后台职位实体（聚合根）实现
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class admin_position extends repository implements admin_position_repository {

    /**
     * 构造函数
     *
     * @param \admin\domain\entity\admin_position $oAggregate
     * @return void
     */
    public function __construct(aggregate $objAggregate) {
        parent::__construct ( $objAggregate );
    }

    /**
     * 取得所有记录
     *
     * @param null|callback $mixCallback
     * @return \queryyetsimple\support\collection
     */
    public function all($mixSpecification = null) {
        return parent::all ( $this->specification ( function ($objSelect) {
            $objSelect->orderBy ( 'sort DESC' );
        }, $mixSpecification ) );
    }
}
