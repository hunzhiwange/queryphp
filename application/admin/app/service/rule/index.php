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

namespace admin\app\service\rule;

use common\is\repository\rule as repository;
use common\is\tree\tree;

/**
 * 后台权限列表.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.11
 *
 * @version 1.0
 */
class index
{
    /**
     * 权限仓储.
     *
     * @var \common\is\repository\rule
     */
    protected $oRepository;

    /**
     * 构造函数.
     *
     * @param \common\is\repository\rule $oRepository
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
        return $this->parseMenuList($this->oRepository->all());
    }

    /**
     * 将节点载入节点树并返回树结构.
     *
     * @param \queryyetsimple\support\collection $objRule
     *
     * @return array
     */
    protected function parseMenuList($objRule)
    {
        return $this->createTree($objRule)->forList(function ($arrItem) {
            return array_merge(['id' => $arrItem['value']], $arrItem['data']);
        });
    }

    /**
     * 生成节点树.
     *
     * @param \queryyetsimple\support\collection $objRule
     *
     * @return \common\is\tree\tree
     */
    protected function createTree($objRule)
    {
        return new tree($this->parseToNode($objRule));
    }

    /**
     * 转换为节点数组.
     *
     * @param \queryyetsimple\support\collection $objRule
     *
     * @return array
     */
    protected function parseToNode($objRule)
    {
        $arrNode = [];
        foreach ($objRule as $oRule) {
            $arrNode[] = [
                $oRule->id,
                $oRule->pid,
                $oRule->toArray(),
            ];
        }

        return $arrNode;
    }
}
