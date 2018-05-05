<?php declare(strict_types=1);
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
     * 是否存在子权限
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
