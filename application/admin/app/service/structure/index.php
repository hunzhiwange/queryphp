<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\structure;

use common\is\tree\tree;
use admin\is\repository\structure as repository;

/**
 * 后台部门列表
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class index
{

    /**
     * 后台部门仓储
     *
     * @var \admin\is\repository\structure
     */
    protected $oRepository;

    /**
     * 构造函数
     *
     * @param \admin\is\repository\structure $oRepository
     * @return void
     */
    public function __construct(repository $oRepository)
    {
        $this->oRepository = $oRepository;
    }

    /**
     * 响应方法
     *
     * @return array
     */
    public function run()
    {
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
        return $this->createTree($objStructure)->forList(function ($arrItem) {
            return array_merge(['id' => $arrItem['value']], $arrItem['data']);
        });
    }

    /**
     * 生成节点树
     *
     * @param \queryyetsimple\support\collection $objStructure
     * @return \common\is\tree\tree
     */
    protected function createTree($objStructure)
    {
        return new tree($this->parseToNode($objStructure));
    }

    /**
     * 转换为节点数组
     *
     * @param \queryyetsimple\support\collection $objStructure
     * @return array
     */
    protected function parseToNode($objStructure)
    {
        $arrNode = [];
        foreach ($objStructure as $oStructure) {
            $arrNode[] = [
                $oStructure->id,
                $oStructure->pid,
                $oStructure->toArray()
            ];
        }
        return $arrNode;
    }
}
