<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\service\structure;

use queryyetsimple\mvc\model_not_found;
use admin\is\repository\admin_structure as repository;

/**
 * 后台部门状态更新
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class enable
{

    /**
     * 后台部门仓储
     *
     * @var \admin\is\repository\admin_structure
     */
    protected $oRepository;

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
     * @param string $strStatus
     * @return array
     */
    public function run($intId, $strStatus)
    {
        return $this->oRepository->update($this->entify($intId, $strStatus));
    }

    /**
     * 验证参数
     *
     * @param int $intId
     * @param string $strStatus
     * @return \admin\domain\entity\admin_structure
     */
    protected function entify($intId, $strStatus)
    {
        $objStructure = $this->find($intId);
        $objStructure->forceProp('status', $strStatus);
        return $objStructure;
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
            throw new update_failed($oE->getMessage());
        }
    }
}
