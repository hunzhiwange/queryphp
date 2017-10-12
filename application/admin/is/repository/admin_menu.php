<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\is\repository;

use admin\domain\entity\admin_menu as aggregate;
use admin\domain\repository\admin_menu as repository;

/**
 * 后台菜单实体（聚合根）实现
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class admin_menu implements repository {
    
    /**
     * 后台菜单聚合根
     *
     * @var \admin\domain\entity\admin_menu
     */
    protected $oAggregate;
    
    /**
     * 构造函数
     *
     * @param \admin\domain\entity\admin_menu $oAggregate            
     * @return void
     */
    public function __construct(aggregate $oAggregate) {
        $this->oAggregate = $oAggregate;
    }
    
    /**
     * 取得所有记录
     *
     * @return \queryyetsimple\support\collection
     */
    public function all() {
        return $this->oAggregate->orderBy ( 'sort' )->getAll ();
    }
}
