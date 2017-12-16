<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\menu;

use common\is\tree\tree;
use queryyetsimple\mvc\model_not_found;
use common\is\repository\menu as repository;

/**
 * 菜单编辑更新
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class update
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
     * @param array $aMenu
     * @return array
     */
    public function run($aMenu)
    {
        return $this->oRepository->update($this->entify($aMenu));
    }

    /**
     * 验证参数
     *
     * @param array $aMenu
     * @return \common\domain\entity\menu
     */
    protected function entify(array $aMenu)
    {
        $objMenu = $this->find($aMenu['id']);

        $aMenu['pid'] = $this->parseParentId($aMenu['pid']);
        if ($aMenu['id'] == $aMenu['pid']) {
            throw new update_failed(__('菜单父级不能为自己'));
        }

        if ($this->createTree()->hasChildren($aMenu['id'], [
            $aMenu['pid']
        ])) {
            throw new update_failed(__('菜单父级不能为自己的子菜单'));
        }

        $aMenu['sort'] = $this->parseSiblingSort($aMenu['pid']);
        $objMenu->forceProps($this->data($aMenu));

        return $objMenu;
    }

    /**
     * 查找实体
     *
     * @param int $intId
     * @return \common\domain\entity\menu|void
     */
    protected function find($intId)
    {
        try {
            return $this->oRepository->findOrFail($intId);
        } catch (model_not_found $oE) {
            throw new update_failed($oE->getMessage());
        }
    }

    /**
     * 生成节点树
     *
     * @return \common\is\tree\tree
     */
    protected function createTree()
    {
        return new tree($this->parseToNode($this->oRepository->all()));
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
                $oMenu->title
            ];
        }
        return $arrNode;
    }

    /**
     * 组装 POST 数据
     *
     * @param array $aMenu
     * @return array
     */
    protected function data(array $aMenu)
    {
        return [
            'pid' => intval($aMenu['pid']),
            'title' => trim($aMenu['title']),
            'name' => trim($aMenu['name']),
            'path' => trim($aMenu['path']),
            'sort' => intval($aMenu['sort']),
            'status' => $aMenu['status'] === true ? 'enable' : 'disable',
            'component' => trim($aMenu['component']),
            'icon' => trim($aMenu['icon']),
            'app' => trim($aMenu['app']),
            'controller' => trim($aMenu['controller']),
            'action' => trim($aMenu['action']),
            'type' => trim($aMenu['type']),
            'siblings' => trim($aMenu['siblings']),
            'rule' => trim($aMenu['rule'])
        ];
    }

    /**
     * 分析父级数据
     *
     * @param array $aPid
     * @return int
     */
    protected function parseParentId(array $aPid)
    {
        $intPid = intval(array_pop($aPid));
        if ($intPid < 0) {
            $intPid = 0;
        }

        return $intPid;
    }

    /**
     * 分析兄弟节点最靠下面的排序值
     *
     * @param int $nPid
     * @return int
     */
    protected function parseSiblingSort($nPid)
    {
        $mixSibling = $this->oRepository->siblingNodeBySort($nPid);
        return $mixSibling ? $mixSibling->sort-1 : 500;
    }
}
