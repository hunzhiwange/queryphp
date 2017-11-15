<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\service\position;

use common\is\tree\tree;
use admin\is\repository\admin_position as repository;

/**
 * 后台职位新增
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class create
{

    /**
     * 后台职位仓储
     *
     * @var \admin\is\repository\admin_position
     */
    protected $oRepository;

    /**
     * 父级职位
     *
     * @var int
     */
    protected $intParentId;

    /**
     * 构造函数
     *
     * @param \admin\is\repository\admin_position $oRepository
     * @return void
     */
    public function __construct(repository $oRepository)
    {
        $this->oRepository = $oRepository;
    }

    /**
     * 响应方法
     *
     * @param int $intParentId
     * @return array
     */
    public function run($intParentId = null)
    {
        $this->intParentId = $intParentId;
        return $this->parseStructureList($this->oRepository->all());
    }

    /**
     * 将节点载入节点树并返回树结构
     *
     * @param \queryyetsimple\support\collection $objStructure
     * @return array
     */
    protected function parseStructureList($objStructure)
    {
        return $this->createTree($objStructure)->forSelect($this->intParentId);
    }

    /**
     * 生成节点树
     *
     * @param \queryyetsimple\support\collection $objStructure
     * @return \common\is\tree\tree
     */
    protected function createTree($objStructure)
    {
        $oTree = new tree($this->parseToNode($objStructure));
        $arrTopStructure = $this->oRepository->topNode();
        $oTree->setNode($arrTopStructure ['id'], $arrTopStructure ['pid'], $arrTopStructure ['lable'], true);
        return $oTree;
    }

    /**
     * 转换为节点数组
     *
     * @param \queryyetsimple\support\collection $objStructure
     * @return array
     */
    protected function parseToNode($objStructure)
    {
        $arrNode = [ ];
        foreach ($objStructure as $oStructure) {
            $arrNode [] = [
                    $oStructure->id,
                    $oStructure->pid,
                    $oStructure->name
            ];
        }
        return $arrNode;
    }
}
