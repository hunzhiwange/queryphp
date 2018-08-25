<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace admin\app\service\menu;

use common\is\repository\menu as repository;
use common\is\tree\tree;
use queryyetsimple\mvc\model_not_found;

/**
 * 菜单编辑更新.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
class update
{
    /**
     * 菜单仓储.
     *
     * @var \common\is\repository\menu
     */
    protected $oRepository;

    /**
     * 构造函数.
     *
     * @param \common\is\repository\menu $oRepository
     */
    public function __construct(repository $oRepository)
    {
        $this->oRepository = $oRepository;
    }

    /**
     * 响应方法.
     *
     * @param array $aMenu
     *
     * @return array
     */
    public function run($aMenu)
    {
        return $this->oRepository->update($this->entify($aMenu));
    }

    /**
     * 验证参数.
     *
     * @param array $aMenu
     *
     * @return \common\domain\entity\menu
     */
    protected function entify(array $aMenu)
    {
        $objMenu = $this->find($aMenu['id']);
        $intOldPid = $objMenu->pid;

        $aMenu['pid'] = $this->parseParentId($aMenu['pid']);
        if ($aMenu['id'] === $aMenu['pid']) {
            throw new update_failed(__('菜单父级不能为自己'));
        }

        if ($this->createTree()->hasChildren($aMenu['id'], [
            $aMenu['pid'],
        ])) {
            throw new update_failed(__('菜单父级不能为自己的子菜单'));
        }

        if ($intOldPid !== $objMenu['pid']) {
            $aMenu['sort'] = $this->parseSiblingSort($aMenu['pid']);
        }
        $objMenu->forceProps($this->data($aMenu));

        return $objMenu;
    }

    /**
     * 查找实体.
     *
     * @param int $intId
     *
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
     * 生成节点树.
     *
     * @return \common\is\tree\tree
     */
    protected function createTree()
    {
        return new tree($this->parseToNode($this->oRepository->all()));
    }

    /**
     * 转换为节点数组.
     *
     * @param \queryyetsimple\support\collection $objMenu
     *
     * @return array
     */
    protected function parseToNode($objMenu)
    {
        $arrNode = [];
        foreach ($objMenu as $oMenu) {
            $arrNode[] = [
                $oMenu->id,
                $oMenu->pid,
                $oMenu->title,
            ];
        }

        return $arrNode;
    }

    /**
     * 组装 POST 数据.
     *
     * @param array $aMenu
     *
     * @return array
     */
    protected function data(array $aMenu)
    {
        $aData = [
            'pid'        => (int) ($aMenu['pid']),
            'title'      => trim($aMenu['title']),
            'name'       => trim($aMenu['name']),
            'path'       => trim($aMenu['path']),
            'status'     => true === $aMenu['status'] ? 'enable' : 'disable',
            'component'  => trim($aMenu['component']),
            'icon'       => trim($aMenu['icon']),
            'app'        => trim($aMenu['app']),
            'controller' => trim($aMenu['controller']),
            'action'     => trim($aMenu['action']),
            'type'       => trim($aMenu['type']),
            'siblings'   => trim($aMenu['siblings']),
            'rule'       => trim($aMenu['rule']),
        ];

        if (isset($aMenu['sort'])) {
            $aData['sort'] = (int) ($aMenu['sort']);
        }

        return $aData;
    }

    /**
     * 分析父级数据.
     *
     * @param array $aPid
     *
     * @return int
     */
    protected function parseParentId(array $aPid)
    {
        $intPid = (int) (array_pop($aPid));
        if ($intPid < 0) {
            $intPid = 0;
        }

        return $intPid;
    }

    /**
     * 分析兄弟节点最靠下面的排序值
     *
     * @param int $nPid
     *
     * @return int
     */
    protected function parseSiblingSort($nPid)
    {
        $mixSibling = $this->oRepository->siblingNodeBySort($nPid);

        return $mixSibling ? $mixSibling->sort - 1 : 500;
    }
}
