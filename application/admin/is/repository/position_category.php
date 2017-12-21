<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\is\repository;

use queryyetsimple\mvc\repository;
use admin\domain\entity\position_category as aggregate;
use admin\domain\repository\position_category as repositorys;

/**
 * 后台职位分类实体（聚合根）实现
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.18
 * @version 1.0
 */
class position_category extends repository implements repositorys
{

    /**
     * 构造函数
     *
     * @param \admin\domain\entity\position_category $oAggregate
     * @return void
     */
    public function __construct(aggregate $objAggregate)
    {
        parent::__construct($objAggregate);
    }

    /**
     * 取得所有记录
     *
     * @param null|callback $mixCallback
     * @return \queryyetsimple\support\collection
     */
    public function all($mixSpecification = null)
    {
        return parent::all($this->specification(function ($objSelect) {
            $objSelect->

            orderBy('sort DESC')->

            setColumns('id,name,remark,status');
        }, $mixSpecification));
    }

    /**
     * 最早(后)一个兄弟节点
     *
     * @param string $strSort
     * @return mixed
     */
    public function siblingNodeBySort($strSort = 'ASC')
    {
        return $this->objAggregate->

        orderBy('sort', $strSort)->

        getOne();
    }
}
