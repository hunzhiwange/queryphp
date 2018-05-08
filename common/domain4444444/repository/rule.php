<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\domain\repository;

use queryyetsimple\mvc\irepository;

/**
 * 权限仓储接口
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.11
 * @version 1.0
 */
interface rule extends irepository
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
