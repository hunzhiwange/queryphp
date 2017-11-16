<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\menu;

use queryyetsimple\mvc\model_not_found;
use admin\is\repository\admin_menu as repository;

/**
 * 后台菜单状态更新
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.19
 * @version 1.0
 */
class enable
{

    /**
     * 后台菜单仓储
     *
     * @var \admin\is\repository\admin_menu
     */
    protected $oRepository;

    /**
     * 构造函数
     *
     * @param \admin\is\repository\admin_menu $oRepository
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
     * @return \admin\domain\entity\admin_menu
     */
    protected function entify($intId, $strStatus)
    {
        $objMenu = $this->find($intId);
        $objMenu->forceProp('status', $strStatus);
        return $objMenu;
    }

    /**
     * 查找实体
     *
     * @param int $intId
     * @return \admin\domain\entity\admin_menu|void
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
