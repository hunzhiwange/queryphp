<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\service\structure;

use common\is\tree\tree;
use admin\is\repository\admin_structure as repository;

/**
 * 后台部门列表
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class index {
    
    /**
     * 后台部门仓储
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
        $arrResult = [ ];
        $arrResult ['structure'] = $this->parseStructureList ( $objStructure = $this->oRepository->all () );
        $arrResult ['status'] = $this->parseStatus ( $objStructure );
        return $arrResult;
    }
    
    /**
     * 将节点载入节点树并返回树结构
     *
     * @param \queryyetsimple\support\collection $objStructure           
     * @return array
     */
    protected function parseStructureList($objMenu) {
        return $this->createTree ( $objMenu )->forList ();
    }
    
    /**
     * 获取状态对比
     *
     * @param \queryyetsimple\support\collection $objStructure           
     * @return array
     */
    protected function parseStatus($objStructure) {
        $arrStatus = [ ];
        foreach ( $objStructure as $objValue ) {
            $arrStatus [$objValue ['id']] = $objValue ['status'];
        }
        return $arrStatus;
    }
    
    /**
     * 生成节点树
     *
     * @param \queryyetsimple\support\collection $objStructure           
     * @return \common\is\tree\tree
     */
    protected function createTree($objStructure) {
        return new tree ( $this->parseToNode ( $objStructure ) );
    }
    
    /**
     * 转换为节点数组
     *
     * @param \queryyetsimple\support\collection $objStructure           
     * @return array
     */
    protected function parseToNode($objStructure) {
        $arrNode = [ ];
        foreach ( $objStructure as $oStructure ) {
            $arrNode [] = [ 
                    $oStructure->id,
                    $oStructure->pid,
                    $oStructure->name 
            ];
        }
        return $arrNode;
    }
}