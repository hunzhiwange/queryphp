<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\domain\repository;

use queryyetsimple\mvc\irepository;

/**
 * 菜单实体（聚合根）接口
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
interface menu extends irepository
{

    /**
     * 取得所有记录
     *
     * @param null|callback $mixCallback
     * @return \queryyetsimple\support\collection
     */
    public function all($mixSpecification = null);

    /**
     * 是否存在子菜单
     *
     * @param int $nId
     * @return boolean
     */
    public function hasChildren($nId);

    /**
     * 最早(后)一个兄弟节点
     *
     * @param int $nId
     * @param string $strSort
     * @return mixed
     */
    public function siblingNodeBySort($nPid, $strSort = 'ASC');

}
