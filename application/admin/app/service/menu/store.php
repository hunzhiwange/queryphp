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

use common\domain\entity\menu as entity;
use common\is\repository\menu as repository;

/**
 * 菜单新增保存.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
class store
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
     * @return mixed
     */
    public function run($aMenu)
    {
        $aMenu['pid'] = $this->parseParentId($aMenu['pid']);

        return $this->oRepository->create($this->entity($aMenu));
    }

    /**
     * 创建实体.
     *
     * @param array $aMenu
     *
     * @return \common\domain\entity\menu
     */
    protected function entity(array $aMenu)
    {
        $aMenu['sort'] = $this->parseSiblingSort($aMenu['pid']);

        return new entity($this->data($aMenu));
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
        return [
            'pid'        => (int) ($aMenu['pid']),
            'title'      => trim($aMenu['title']),
            'name'       => trim($aMenu['name']),
            'path'       => trim($aMenu['path']),
            'sort'       => (int) ($aMenu['sort']),
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
