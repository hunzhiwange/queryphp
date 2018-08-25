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

namespace admin\is\repository;

use admin\domain\entity\structure as aggregate;
use admin\domain\repository\structure as structure_repository;
use queryyetsimple\mvc\repository;

/**
 * 后台部门实体（聚合根）实现.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class structure extends repository implements structure_repository
{
    /**
     * 构造函数.
     *
     * @param \admin\domain\entity\structure $oAggregate
     */
    public function __construct(aggregate $objAggregate)
    {
        parent::__construct($objAggregate);
    }

    /**
     * 取得所有记录.
     *
     * @param null|callable $mixCallback
     * @param null|mixed    $mixSpecification
     *
     * @return \queryyetsimple\support\collection
     */
    public function all($mixSpecification = null)
    {
        return parent::all($this->specification(function ($objSelect) {
            $objSelect->orderBy('sort DESC');
        }, $mixSpecification));
    }

    /**
     * 是否存在子菜单.
     *
     * @param int $nId
     *
     * @return bool
     */
    public function hasChildren($nId)
    {
        return $this->count(function ($objSelect) use ($nId) {
            $objSelect->where('pid', $nId);
        }) ? true : false;
    }

    /**
     * 最早(后)一个兄弟节点.
     *
     * @param int    $nPid
     * @param string $strSort
     *
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
