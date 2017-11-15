<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\is\repository;

use queryyetsimple\mvc\repository;
use queryyetsimple\mvc\iaggregate_root;
use admin\domain\entity\admin_structure as aggregate;
use admin\domain\repository\admin_structure as admin_structure_repository;

/**
 * 后台部门实体（聚合根）实现
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class admin_structure extends repository implements admin_structure_repository
{

    /**
     * 构造函数
     *
     * @param \admin\domain\entity\admin_structure $oAggregate
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
     * 是否存在子部门
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
     * 后台部门
     *
     * @return array
     */
    public function topNode()
    {
        return [
                'id' => - 1,
                'pid' => 0,
                'lable' => '选择上级部门'
        ];
    }
}
