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

use common\is\repository\menu as repository;
use queryyetsimple\mvc\model_not_found;

/**
 * 菜单删除.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
class destroy
{
    /**
     * 后台菜单仓储.
     *
     * @var \common\is\repository\menu
     */
    protected $oRepository;

    /**
     * 父级菜单.
     *
     * @var int
     */
    protected $intParentId;

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
     * @param int $intId
     *
     * @return array
     */
    public function run($intId)
    {
        return $this->delete($this->oRepository->find($intId));
    }

    /**
     * 查找实体.
     *
     * @param int $intId
     *
     * @return \common\domain\entity\menu|void
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
     * 删除实体.
     *
     * @param \common\domain\entity\menu $objMenu
     *
     * @return int
     */
    protected function delete($objMenu)
    {
        $this->checkChildren($objMenu->id);

        return $this->oRepository->delete($objMenu);
    }

    /**
     * 判断是否存在子菜单.
     *
     * @param int $intId
     */
    protected function checkChildren($intId)
    {
        if ($this->oRepository->hasChildren($intId)) {
            throw new destroy_failed(__('菜单包含子菜单，无法删除'));
        }
    }
}
