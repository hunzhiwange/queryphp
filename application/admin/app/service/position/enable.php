<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\position;

use queryyetsimple\mvc\model_not_found;
use admin\is\repository\admin_position as repository;

/**
 * 后台职位状态更新
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class enable
{

    /**
     * 后台职位仓储
     *
     * @var \admin\is\repository\admin_position
     */
    protected $oRepository;

    /**
     * 构造函数
     *
     * @param \admin\is\repository\admin_position $oRepository
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
     * @return \admin\domain\entity\admin_position
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
     * @return \admin\domain\entity\admin_position|void
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
