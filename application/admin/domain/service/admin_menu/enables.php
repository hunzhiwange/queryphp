<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\domain\service\admin_menu;

use admin\is\repository\admin_menu as repository;
use queryyetsimple\mvc\exception\model_not_found;

/**
 * 后台菜单启用禁用服务
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class enables {
    
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
     * @param int $intId            
     * @param string $strType            
     * @return void
     */
    public function run($arrId, $strStatus) {
        $this->checkStatus ( $strStatus );
        $this->registerUnitOfWork ( $this->queryMenus ( $arrId ), $strStatus );
        $this->commit ();
    }
    
    /**
     * 验证启用禁用状态
     *
     * @param string $strStatus            
     * @return void
     */
    protected function checkStatus($strStatus) {
        if (! in_array ( $strStatus, [ 
                'disable',
                'enable' 
        ] ))
            throw new enables_failed ( '启用禁用状态不受支持' );
    }
    
    /**
     * 注册工作单元
     *
     * @param \queryyetsimple\support\collection $objCollection            
     * @param string $strStatu            
     * @return void
     */
    protected function registerUnitOfWork($objCollection, $strStatus) {
        foreach ( $objCollection as $objMenu ) {
            $objMenu->forceProp ( 'status', $strStatus );
            $this->oRepository->registerUpdate ( $objMenu );
        }
    }
    
    /**
     * 提交工作单元
     *
     * @return void
     */
    protected function commit() {
        $this->oRepository->registerCommit ();
    }
    
    /**
     * 查找指定 ID 的菜单
     *
     * @param array $arrIds            
     * @return \queryyetsimple\support\collection
     */
    protected function queryMenus(array $arrIds) {
        return $this->oRepository->all ( function ($oSelect) use($arrIds) {
            $oSelect->where ( 'id', 'in', $arrIds )->setColumns ( 'id' );
        } );
    }
}