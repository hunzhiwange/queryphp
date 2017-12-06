<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\menu;

use common\is\tree\tree;
use admin\is\repository\admin_menu as repository;

/**
 * 后台菜单编辑
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class edit
{

    /**
     * 后台菜单仓储
     *
     * @var \admin\is\repository\admin_menu
     */
    protected $oRepository;

    /**
     * 父级菜单
     *
     * @var int
     */
    protected $intParentId;

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
     * @return array
     */
    public function run($intId)
    {
        $arrMenu = $this->oRepository->find($intId)->toArray();
        $arrMenu['pid'] = [- 1]; // 前端自动查找父级

        return $arrMenu;
    }
}
