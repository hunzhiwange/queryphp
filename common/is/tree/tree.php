<?php
// ©2017 http://your.domain.com All rights reserved.
namespace common\is\tree;

use queryyetsimple\support\tree as support_tree;

/**
 * 通用树结构
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class tree
{

    /**
     * 树结构
     *
     * @var \queryyetsimple\support\tree
     */
    protected $oTree;

    /**
     * 构造函数
     *
     * @param array $arrNode
     * @return  void
     */
    public function __construct(array $arrNode)
    {
        $this->oTree = $this->createTree($arrNode);
    }

    /**
     * 树结构节点列表
     *
     * @return array
     */
    public function forList()
    {
        return  $this->oTree->toArray(function ($arrItem) {
            return [
                'id' => $arrItem['value'],
                'label' => $arrItem['data'],
            ];
        });
    }

    /**
     * 树结构节点 select
     *
     * @param  int $iParentId
     * @return array
     */
    public function forSelect($iParentId=null)
    {
        $arrTree = $this->oTree->toArray(function ($arrItem) {
            return [
                'value' => $arrItem['value'],
                'label' => $arrItem['data'],
            ];
        });

        if ($iParentId) {
            $arrSelected = $this->oTree->getParents($iParentId);
        } else {
            $arrSelected = [];
        }

        return ['list' => $arrTree,'selected' => $arrSelected];
    }

    /**
     * 取得子节点
     *
     * @param  int $intId
     * @return array
     */
    public function getChildren($intId)
    {
        return $this->oTree->getChildren($intId);
    }

    /**
     * 是否存在子节点
     *
     * @param  int  $intId
     * @param  array   $arrCheckChildren
     * @param  boolean $booStrict
     * @return boolean
     */
    public function hasChildren($intId, array $arrCheckChildren=[], $booStrict=true)
    {
        return $this->oTree->hasChildren($intId, $arrCheckChildren, $booStrict);
    }

    /**
     * 基于节点创建树
     *
     * @param  array  $arrNode
     * @return \queryyetsimple\support\tree
     */
    protected function createTree(array $arrNode)
    {
        return  new support_tree($arrNode);
    }

    /**
     * 缺省方法
     *
     * @param 方法名 $sMethod
     * @param 参数 $arrArgs
     * @return mixed
     */
    public function __call($sMethod, $arrArgs)
    {
        return call_user_func_array([
                $this->oTree,
                $sMethod
        ], $arrArgs);
    }
}
