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

namespace common\is\repository;

use common\domain\entity\rule as aggregate;
use common\domain\repository\rule as rule_repository;
use queryyetsimple\mvc\repository;

/**
 * 权限仓储实现.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.11
 *
 * @version 1.0
 */
class rule extends repository implements rule_repository
{
    /**
     * 权限聚合根.
     *
     * @var \common\domain\entity\rule
     */
    protected $oAggregate;

    /**
     * 构造函数.
     *
     * @param \common\domain\entity\rule $objAggregate
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
     * 是否存在子权限.
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
     * @param int    $nId
     * @param string $strSort
     * @param mixed  $nPid
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
