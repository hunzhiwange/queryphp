<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\is\repository;

use queryyetsimple\mvc\repository;
use common\domain\entity\menu as aggregate;
use common\domain\repository\menu as menu_repository;

/**
 * 菜单实体（聚合根）实现
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class menu extends repository implements menu_repository
{

    /**
     * 构造函数
     *
     * @param \common\domain\entity\menu $oAggregate
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
            $objSelect->orderBy('sort DESC');
        }, $mixSpecification));
    }

    /**
     * 是否存在子菜单
     *
     * @param int $nId
     * @return boolean
     */
    public function hasChildren($nId)
    {
        return $this->count(function ($objSelect) use ($nId) {
            $objSelect->where('pid', $nId);
        }) ? true : false;
    }

    /**
     * 最早(后)一个兄弟节点
     *
     * @param int $nId
     * @param string $strSort
     * @return mixed
     */
    public function siblingNodeBySort($nPid, $strSort = 'ASC')
    {
        return $this->objAggregate->

        where('pid', $nPid)->

        orderBy('sort', $strSort)->

        getOne();
    }
}
