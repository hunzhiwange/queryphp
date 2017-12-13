<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\rule;

use common\is\tree\tree;
use common\is\repository\rule as repository;

/**
 * 后台权限列表
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.11
 * @version 1.0
 */
class index
{

    /**
     * 权限仓储
     *
     * @var \common\is\repository\rule
     */
    protected $oRepository;

    /**
     * 构造函数
     *
     * @param \common\is\repository\rule $oRepository
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
        return $this->parseMenuList($this->oRepository->all());
    }

    /**
     * 将节点载入节点树并返回树结构
     *
     * @param \queryyetsimple\support\collection $objRule
     * @return array
     */
    protected function parseMenuList($objRule)
    {
        return $this->createTree($objRule)->forList(function ($arrItem) {
            return array_merge(['id' => $arrItem['value']], $arrItem['data']);
        });
    }

    /**
     * 生成节点树
     *
     * @param \queryyetsimple\support\collection $objRule
     * @return \common\is\tree\tree
     */
    protected function createTree($objRule)
    {
        return new tree($this->parseToNode($objRule));
    }

    /**
     * 转换为节点数组
     *
     * @param \queryyetsimple\support\collection $objRule
     * @return array
     */
    protected function parseToNode($objRule)
    {
        $arrNode = [];
        foreach ($objRule as $oRule) {
            $arrNode[] = [
                $oRule->id,
                $oRule->pid,
                $oRule->toArray()
            ];
        }
        return $arrNode;
    }
}
