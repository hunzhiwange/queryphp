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

use admin\domain\entity\position_category as aggregate;
use admin\domain\repository\position_category as repositorys;
use queryyetsimple\mvc\repository;

/**
 * 后台职位分类实体（聚合根）实现.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.18
 *
 * @version 1.0
 */
class position_category extends repository implements repositorys
{
    /**
     * 构造函数.
     *
     * @param \admin\domain\entity\position_category $oAggregate
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
            $objSelect->

            orderBy('sort DESC')->

            setColumns('id,name,remark,status');
        }, $mixSpecification));
    }

    /**
     * 最早(后)一个兄弟节点.
     *
     * @param string $strSort
     *
     * @return mixed
     */
    public function siblingNodeBySort($strSort = 'ASC')
    {
        return $this->objAggregate->
        orderBy('sort', $strSort)->

        getOne();
    }
}
