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

namespace admin\app\service\position;

use admin\is\repository\admin_position as repository;

/**
 * 后台职位列表.
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
     * 后台职位仓储.
     *
     * @var \admin\is\repository\admin_menu
     */
    protected $oRepository;

    /**
     * 构造函数.
     *
     * @param \admin\is\repository\admin_menu $oRepository
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
        $this->parseList($this->queryList());
    }

    /**
     * 将节点载入节点树并返回树结构.
     *
     * @param \queryyetsimple\support\collection $objPosition
     *
     * @return array
     */
    protected function parseList($objPosition)
    {
        return $objPosition->toArray();
    }

    /**
     * 返回所有查询职位.
     *
     * @return \queryyetsimple\support\collection
     */
    protected function queryList()
    {
        return $this->oRepository->all();
    }
}
