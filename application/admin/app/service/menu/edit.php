<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\service\menu;

use common\is\tree\tree;
use admin\is\repository\admin_menu as repository;

/**
 * 后台菜单编辑
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class edit {
    
    /**
     * 后台菜单仓储
     *
     * @var \admin\is\repository\admin_menu
     */
    protected $oRepository;
    
    /**
     * 父级菜单
     *
     * @var int
     */
    protected $intParentId;
    
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
     * @param int $intId            
     * @return array
     */
    public function run($intId) {
        $arrMenu = $this->oRepository->find ( $intId )->toArray ();
        $arrSelect = $this->getSelectTree ( $arrMenu ['pid'] );
        $arrMenu ['pid'] = $arrSelect ['selected'] ?  : [ 
                - 1 
        ];
        
        return [ 
                'one' => $arrMenu,
                'list' => $arrSelect ['list'] 
        ];
    }
    
    /**
     * 分析树结构数据
     *
     * @param int $intParentId            
     * @return array
     */
    protected function getSelectTree($intParentId) {
        $this->intParentId = $intParentId;
        return $this->parseMenuList ( $this->oRepository->all () );
    }
    
    /**
     * 将节点载入节点树并返回树结构
     *
     * @param \queryyetsimple\support\collection $objMenu            
     * @return array
     */
    protected function parseMenuList($objMenu) {
        return $this->createTree ( $objMenu )->forSelect ( $this->intParentId );
    }
    
    /**
     * 生成节点树
     *
     * @param \queryyetsimple\support\collection $objMenu            
     * @return \common\is\tree\tree
     */
    protected function createTree($objMenu) {
        $oTree = new tree ( $this->parseToNode ( $objMenu ) );
        $arrTopMenu = $this->oRepository->topNode ();
        $oTree->setNode ( $arrTopMenu ['id'], $arrTopMenu ['pid'], $arrTopMenu ['lable'], true );
        return $oTree;
    }
    
    /**
     * 转换为节点数组
     *
     * @param \queryyetsimple\support\collection $objMenu            
     * @return array
     */
    protected function parseToNode($objMenu) {
        $arrNode = [ ];
        foreach ( $objMenu as $oMenu ) {
            $arrNode [] = [ 
                    $oMenu->id,
                    $oMenu->pid,
                    $oMenu->title 
            ];
        }
        return $arrNode;
    }
}