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

namespace admin\app\service\structure;

use admin\is\repository\structure as repository;
use common\is\tree\tree;
use queryyetsimple\mvc\model_not_found;

/**
 * 后台部门编辑更新.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class update
{
    /**
     * 后台部门仓储.
     *
     * @var \admin\is\repository\structure
     */
    protected $oRepository;

    /**
     * 构造函数.
     *
     * @param \admin\is\repository\structure $oRepository
     */
    public function __construct(repository $oRepository)
    {
        $this->oRepository = $oRepository;
    }

    /**
     * 响应方法.
     *
     * @param array $aStructure
     *
     * @return array
     */
    public function run($aStructure)
    {
        return $this->oRepository->update($this->entify($aStructure));
    }

    /**
     * 验证参数.
     *
     * @param array $aStructure
     *
     * @return \admin\domain\entity\structure
     */
    protected function entify(array $aStructure)
    {
        $objStructure = $this->find($aStructure['id']);
        $intOldPid = $objStructure->pid;

        $aStructure['pid'] = $this->parseParentId($aStructure['pid']);
        if ($aStructure['id'] === $aStructure['pid']) {
            throw new update_failed(__('部门父级不能为自己'));
        }

        if ($this->createTree()->hasChildren($aStructure['id'], [
            $aStructure['pid'],
        ])) {
            throw new update_failed(__('部门父级不能为自己的子部门'));
        }

        if ($intOldPid !== $aStructure['pid']) {
            $aStructure['sort'] = $this->parseSiblingSort($aStructure['pid']);
        }
        $objStructure->forceProps($this->data($aStructure));

        return $objStructure;
    }

    /**
     * 查找实体.
     *
     * @param int $intId
     *
     * @return \admin\domain\entity\structure|void
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
     * @param \queryyetsimple\support\collection $objStructure
     *
     * @return array
     */
    protected function parseToNode($objStructure)
    {
        $arrNode = [];
        foreach ($objStructure as $oStructure) {
            $arrNode[] = [
                $oStructure->id,
                $oStructure->pid,
                $oStructure->name,
            ];
        }

        return $arrNode;
    }

    /**
     * 组装 POST 数据.
     *
     * @param array $aStructure
     *
     * @return array
     */
    protected function data(array $aStructure)
    {
        $aData = [
            'name' => $aStructure['name'],
            'pid'  => (int) ($aStructure['pid']),
        ];

        if (isset($aStructure['sort'])) {
            $aData['sort'] = (int) ($aStructure['sort']);
        }

        return $aData;
    }

    /**
     * 分析父级数据.
     *
     * @param
     *            array $aPid
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
