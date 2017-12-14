<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\rule;

use common\is\tree\tree;
use common\domain\entity\rule as entity;
use common\is\repository\rule as repository;

/**
 * 后台权限新增保存
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.11
 * @version 1.0
 */
class store
{

    /**
     * 后台权限仓储
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
     * @param array $aRule
     * @return mixed
     */
    public function run($aRule)
    {
        $aRule['pid'] = $this->parseParentId($aRule['pid']);
        return $this->oRepository->create($this->entity($aRule));
    }

    /**
     * 创建实体
     *
     * @param array $aRule
     * @return \common\domain\entity\rule
     */
    protected function entity(array $aRule)
    {
        $aRule['sort'] = $this->parseSiblingSort($aRule['pid']);
        return new entity($this->data($aRule));
    }

    /**
     * 组装 POST 数据
     *
     * @param array $aRule
     * @return array
     */
    protected function data(array $aRule)
    {
        return [
            'pid' => intval($aRule['pid']),
            'title' => trim($aRule['title']),
            'name' => trim($aRule['name']),
            'sort' => intval($aRule['sort']),
            'status' => $aRule['status'] === true ? 'enable' : 'disable',
            'app' => trim($aRule['app']),
            'type' => trim($aRule['type']),
            'value' => implode(',', $aRule['value'])
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
