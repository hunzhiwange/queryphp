<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\domain\service\admin_position;

use queryyetsimple\mvc\exception\model_not_found;
use admin\is\repository\admin_position as repository;

/**
 * 后台职位排序更新服务
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class order {
    
    /**
     * 后台职位仓储
     *
     * @var \admin\is\repository\admin_position
     */
    protected $oRepository;
    
    /**
     * 构造函数
     *
     * @param \admin\is\repository\admin_position $oRepository            
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
    public function run($intId, $strType) {
        $objStructure = $this->find ( $intId );
        
        $objCollection = $this->siblings ( $objStructure ['pid'] );
        $intIndex = $this->validAndReturnIndex ( $intId, $objCollection, $strType );
        
        $this->registerUnitOfWork ( $objCollection, $intIndex, $strType );
        $this->commit ();
    }
    
    /**
     * 验证并返回索引 ID
     *
     * @return int
     */
    protected function validAndReturnIndex($intId, $objCollection, $strType) {
        switch ($strType) {
            case 'top' :
            case 'up' :
                $this->validTopIndex ( $intIndex = $this->currentIndex ( $objCollection, $intId ) );
                break;
            case 'down' :
                $this->validBottomIndex ( $intIndex = $this->currentIndex ( $objCollection, $intId ), count ( $objCollection ) );
                break;
            default :
                throw new order_failed ( '不受支持的排序操作方式' );
        }
        
        return $intIndex;
    }
    
    /**
     * 注册工作单元
     *
     * @param \queryyetsimple\support\collection $objCollection            
     * @param int $intIndex            
     * @param string $strType            
     * @return void
     */
    protected function registerUnitOfWork($objCollection, $intIndex, $strType) {
        foreach ( $objCollection as $intKey => $objChild ) {
            $objChild->forceProp ( 'sort', $intId = $this->parseOrder ( $this->{'parse' . ucwords ( $strType ) . 'OrderIndex'} ( $intKey, $intIndex ) ) );
            $this->oRepository->registerUpdate ( $objChild );
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
     * 获取当前索引
     *
     * @param \queryyetsimple\support\collection $objCollection            
     * @param int $intId            
     * @return int
     */
    protected function currentIndex($objCollection, $intId) {
        $intIndex = 0;
        foreach ( $objCollection as $intKey => $objChild ) {
            if ($objChild->id == $intId) {
                $intIndex = $intKey;
                break;
            }
        }
        
        return $intIndex;
    }
    
    /**
     * 验证是否为最顶层节点
     *
     * @param int $intIndex            
     * @return void
     */
    protected function validTopIndex($intIndex) {
        if ($intIndex == 0) {
            throw new order_failed ( '已经是顶层节点' );
        }
    }
    
    /**
     * 验证是否为最底层节点
     *
     * @param int $intIndex            
     * @param int $intTotal            
     * @return void
     */
    protected function validBottomIndex($intIndex, $intTotal) {
        if ($intIndex == $intTotal - 1) {
            throw new order_failed ( '已经是最底层节点' );
        }
    }
    
    /**
     * 返回真实排序 KEY
     *
     * @param int $intOrderKey            
     * @return int
     */
    protected function parseOrder($intOrderKey) {
        return 500 - $intOrderKey;
    }
    
    /**
     * 分析置顶排序索引 KEY
     *
     * @param int $intKey            
     * @param int $intIndex            
     * @return int
     */
    protected function parseTopOrderIndex($intKey, $intIndex) {
        if ($intKey == $intIndex) {
            $intTemp = 0;
        } else {
            $intTemp = $intKey + 1;
        }
        
        return $intTemp;
    }
    
    /**
     * 分析上移排序索引 KEY
     *
     * @param int $intKey            
     * @param int $intIndex            
     * @return int
     */
    protected function parseUpOrderIndex($intKey, $intIndex) {
        if ($intKey == $intIndex - 1) {
            $intTemp = $intIndex;
        } elseif ($intKey == $intIndex) {
            $intTemp = $intIndex - 1;
        } else {
            $intTemp = $intKey;
        }
        
        return $intTemp;
    }
    
    /**
     * 分析下移排序索引 KEY
     *
     * @param int $intKey            
     * @param int $intIndex            
     * @return int
     */
    protected function parseDownOrderIndex($intKey, $intIndex) {
        if ($intKey == $intIndex) {
            $intTemp = $intIndex + 1;
        } elseif ($intKey == $intIndex + 1) {
            $intTemp = $intIndex;
        } else {
            $intTemp = $intKey;
        }
        
        return $intTemp;
    }
    
    /**
     * 查找实体
     *
     * @param array $aMenu            
     * @return \admin\domain\entity\admin_menu|void
     */
    protected function find($intId) {
        try {
            return $this->oRepository->findOrFail ( $intId );
        } catch ( model_not_found $oE ) {
            throw new order_failed ( $oE->getMessage () );
        }
    }
    
    /**
     * 查找当前节点的兄弟节点
     *
     * @param int $intParentId            
     * @return \queryyetsimple\support\collection
     */
    protected function siblings($intParentId) {
        return $this->oRepository->all ( function ($oSelect) use($intParentId) {
            $oSelect->where ( 'pid', $intParentId )->setColumns ( 'id,sort' );
        } );
    }
}