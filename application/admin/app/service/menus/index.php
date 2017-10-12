<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\service\menus;

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
        return $this->parseMenuList ( $this->oRepository->all () );
    }
    
    /**
     * 将节点载入节点树并返回树结构
     *
     * @param array $arrMenuList            
     * @return array
     */
    protected function parseMenuList($arrMenuList) {
        return $this->createTree ( $arrMenuList )->forList ();
    }
    
    /**
     * 生成节点树
     *
     * @param array $arrMenuList            
     * @return \common\is\tree\tree
     */
    protected function createTree($arrMenuList) {
        return new tree ( $this->parseToNode ( $arrMenuList ) );
    }
    
    /**
     * 转换为节点数组
     *
     * @param array $arrMenuList            
     * @return array
     */
    protected function parseToNode($arrMenuList) {
        $arrNode = [ ];
        foreach ( $arrMenuList as $oMenu ) {
            $arrNode [] = [ 
                    $oMenu->id,
                    $oMenu->pid,
                    $oMenu->title 
            ];
        }
        return $arrNode;
    }
}