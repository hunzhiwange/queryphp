<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\position_category;

use queryyetsimple\mvc\model_not_found;
use admin\is\repository\position_category as repository;

/**
 * 后台职位分类删除
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.19
 * @version 1.0
 */
class destroy
{

    /**
     * 后台职位分类仓储
     *
     * @var \admin\is\repository\position_category
     */
    protected $oRepository;

    /**
     * 构造函数
     *
     * @param \admin\is\repository\position_category $oRepository
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
     * @return \admin\domain\entity\position_category|void
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
     * @param \admin\domain\entity\position_category $objCategory
     * @return int
     */
    protected function delete($objCategory)
    {
        return $this->oRepository->delete($objCategory);
    }
}
