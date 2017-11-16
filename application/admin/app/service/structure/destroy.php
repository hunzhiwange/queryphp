<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\structure;

use admin\app\service\structure\destroy_failed;
use admin\is\repository\admin_structure as repository;

/**
 * 后台部门删除
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class destroy
{

    /**
     * 后台部门仓储
     *
     * @var \admin\is\repository\admin_structure
     */
    protected $oRepository;

    /**
     * 父级部门
     *
     * @var int
     */
    protected $intParentId;

    /**
     * 构造函数
     *
     * @param \admin\is\repository\admin_structure $oRepository
     * @return void
     */
    public function __construct(repository $oRepository)
    {
        $this->oRepository = $oRepository;
    }

    /**
     * 响应方法
     *
     * @param int $intId
     * @return array
     */
    public function run($intId)
    {
        return $this->delete($this->oRepository->find($intId));
    }

    /**
     * 查找实体
     *
     * @param int $intId
     * @return \admin\domain\entity\admin_structure|void
     */
    protected function find($intId)
    {
        try {
            return $this->oRepository->findOrFail($intId);
        } catch (model_not_found $oE) {
            throw new destroy_failed($oE->getMessage());
        }
    }

    /**
     * 删除实体
     *
     * @param \admin\domain\entity\admin_structure $objStructure
     * @return int
     */
    protected function delete($objStructure)
    {
        $this->checkChildren($objStructure->id);
        return $this->oRepository->delete($objStructure);
    }

    /**
     * 判断是否存在子部门
     *
     * @param int $intId
     * @return void
     */
    protected function checkChildren($intId)
    {
        if ($this->oRepository->hasChildren($intId)) {
            throw new destroy_failed('部门包含子部门，无法删除');
        }
    }
}
