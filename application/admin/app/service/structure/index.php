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

/**
 * 后台部门列表.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class index
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
     * @return array
     */
    public function run()
    {
        return $this->parseStructureList($this->oRepository->all());
    }

    /**
     * 将节点载入节点树并返回树结构.
     *
     * @param \queryyetsimple\support\collection $objStructure
     *
     * @return array
     */
    protected function parseStructureList($objStructure)
    {
        return $this->createTree($objStructure)->forList(function ($arrItem) {
            return array_merge(['id' => $arrItem['value']], $arrItem['data']);
        });
    }

    /**
     * 生成节点树.
     *
     * @param \queryyetsimple\support\collection $objStructure
     *
     * @return \common\is\tree\tree
     */
    protected function createTree($objStructure)
    {
        return new tree($this->parseToNode($objStructure));
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
                $oStructure->toArray(),
            ];
        }

        return $arrNode;
    }
}
