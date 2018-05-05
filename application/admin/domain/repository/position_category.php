<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\domain\repository;

use queryyetsimple\mvc\irepository;

/**
 * 后台职位分类实体（聚合根）接口
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.18
 * @version 1.0
 */
interface position_category extends irepository
{

    /**
     * 取得所有记录
     *
     * @param null|callback $mixCallback
     * @return \queryyetsimple\support\collection
     */
    public function all($mixSpecification = null);

    /**
     * 最早(后)一个兄弟节点
     *
     * @param string $strSort
     * @return mixed
     */
    public function siblingNodeBySort($strSort = 'ASC');
}
