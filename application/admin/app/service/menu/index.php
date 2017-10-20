<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\service\menu;

use common\is\tree\tree;
use admin\is\repository\admin_menu as repository;

/**
 * 后台菜单列表
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class index {
    
    /**
     * 后台菜单仓储
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
        $arrResult ['menu'] = $this->parseMenuList ( $objMenu = $this->oRepository->all () );
        $arrResult ['status'] = $this->parseStatus ( $objMenu );
        return $arrResult;
    }
    
    /**
     * 将节点载入节点树并返回树结构
     *
     * @param \queryyetsimple\support\collection $objMenu            
     * @return array
     */
    protected function parseMenuList($objMenu) {
        return $this->createTree ( $objMenu )->forList ();
    }
    
    /**
     * 获取状态对比
     *
     * @param \queryyetsimple\support\collection $objMenu            
     * @return array
     */
    protected function parseStatus($objMenu) {
        $arrStatus = [ ];
        foreach ( $objMenu as $objValue ) {
            $arrStatus [$objValue ['id']] = $objValue ['status'];
        }
        return $arrStatus;
    }
    
    /**
     * 生成节点树
     *
     * @param \queryyetsimple\support\collection $objMenu            
     * @return \common\is\tree\tree
     */
    protected function createTree($objMenu) {
        return new tree ( $this->parseToNode ( $objMenu ) );
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