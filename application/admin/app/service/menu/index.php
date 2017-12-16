<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\menu;

use common\is\tree\tree;
use common\is\repository\menu as repository;

/**
 * 菜单列表
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class index
{

    /**
     * 菜单仓储
     *
     * @var \common\is\repository\menu
     */
    protected $oRepository;

    /**
     * 构造函数
     *
     * @param \common\is\repository\menu $oRepository
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
     * @param \queryyetsimple\support\collection $objMenu
     * @return array
     */
    protected function parseMenuList($objMenu)
    {
        return $this->createTree($objMenu)->forList(function ($arrItem) {
            return array_merge(['id' => $arrItem['value']], $arrItem['data']);
        });
    }

    /**
     * 生成节点树
     *
     * @param \queryyetsimple\support\collection $objMenu
     * @return \common\is\tree\tree
     */
    protected function createTree($objMenu)
    {
        return new tree($this->parseToNode($objMenu));
    }

    /**
     * 转换为节点数组
     *
     * @param \queryyetsimple\support\collection $objMenu
     * @return array
     */
    protected function parseToNode($objMenu)
    {
        $arrNode = [];
        foreach ($objMenu as $oMenu) {
            $arrNode[] = [
                $oMenu->id,
                $oMenu->pid,
                $oMenu->toArray()
            ];
        }
        return $arrNode;
    }
}
