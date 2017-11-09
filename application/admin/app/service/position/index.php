<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\service\position;

use admin\is\repository\admin_position as repository;

/**
 * 后台职位列表
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class index {
    
    /**
     * 后台职位仓储
     *
     * @var \admin\is\repository\admin_menu
     */
    protected $oRepository;
    
    /**
     * 构造函数
     *
     * @param \admin\is\repository\admin_menu $oRepository            
     * @return void
     */
    public function __construct(repository $oRepository) {
        $this->oRepository = $oRepository;
    }
    
    /**
     * 响应方法
     *
     * @return array
     */
    public function run() {
        $this->parseList ( $this->queryList() );
    }

    /**
     * 将节点载入节点树并返回树结构
     *
     * @param \queryyetsimple\support\collection $objPosition          
     * @return array
     */
    protected function parseList($objPosition) {
        return $objPosition->toArray();
    }

    /**
     * 返回所有查询职位
     *      
     * @return \queryyetsimple\support\collection
     */
    protected function queryList( ) {
        return $this->oRepository->all ();
    }

}