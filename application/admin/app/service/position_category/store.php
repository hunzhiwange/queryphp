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

namespace admin\app\service\position_category;

use admin\domain\entity\position_category as entity;
use admin\is\repository\position_category as repository;

/**
 * 后台职业分类新增保存.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.19
 *
 * @version 1.0
 */
class store
{
    /**
     * 后台部门仓储.
     *
     * @var \admin\is\repository\position_category
     */
    protected $oRepository;

    /**
     * 构造函数.
     *
     * @param \admin\is\repository\position_category $oRepository
     */
    public function __construct(repository $oRepository)
    {
        $this->oRepository = $oRepository;
    }

    /**
     * 响应方法.
     *
     * @param array $aCategory
     *
     * @return array
     */
    public function run($aCategory)
    {
        return $this->oRepository->create($this->entity($aCategory));
    }

    /**
     * 创建实体.
     *
     * @param array $aCategory
     *
     * @return \admin\domain\entity\position_category
     */
    protected function entity(array $aCategory)
    {
        $aCategory['sort'] = $this->parseSiblingSort();

        return new entity($this->data($aCategory));
    }

    /**
     * 组装 POST 数据.
     *
     * @param array $aCategory
     *
     * @return array
     */
    protected function data(array $aCategory)
    {
        return [
            'name'   => trim($aCategory['name']),
            'remark' => trim($aCategory['remark']),
            'status' => true === $aCategory['status'] ? 'enable' : 'disable',
            'sort'   => (int) ($aCategory['sort']),
        ];
    }

    /**
     * 分析兄弟节点最靠上面的排序值
     *
     * @return int
     */
    protected function parseSiblingSort()
    {
        $mixSibling = $this->oRepository->siblingNodeBySort('DESC');

        return $mixSibling ? $mixSibling->sort + 1 : 500;
    }
}
