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

namespace admin\app\service\structure;

use admin\is\repository\structure as repository;
use queryyetsimple\mvc\model_not_found;

/**
 * 后台部门删除.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class destroy
{
    /**
     * 后台部门仓储.
     *
     * @var \admin\is\repository\structure
     */
    protected $oRepository;

    /**
     * 父级部门.
     *
     * @var int
     */
    protected $intParentId;

    /**
     * 构造函数.
     *
     * @param \admin\is\repository\structure $oRepository
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
     * @return \admin\domain\entity\structure|void
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
     * @param \admin\domain\entity\structure $objStructure
     *
     * @return int
     */
    protected function delete($objStructure)
    {
        $this->checkChildren($objStructure->id);

        return $this->oRepository->delete($objStructure);
    }

    /**
     * 判断是否存在子部门.
     *
     * @param int $intId
     */
    protected function checkChildren($intId)
    {
        if ($this->oRepository->hasChildren($intId)) {
            throw new destroy_failed(__('部门包含子部门，无法删除'));
        }
    }
}
