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

namespace admin\app\service\position_category;

use admin\is\repository\position_category as repository;
use queryyetsimple\mvc\model_not_found;

/**
 * 后台职位分类删除.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.19
 *
 * @version 1.0
 */
class destroy
{
    /**
     * 后台职位分类仓储.
     *
     * @var \admin\is\repository\position_category
     */
    protected $oRepository;

    /**
     * 构造函数.
     *
     * @param \admin\is\repository\position_category $oRepository
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
     * 删除实体.
     *
     * @param \admin\domain\entity\position_category $objCategory
     *
     * @return int
     */
    protected function delete($objCategory)
    {
        return $this->oRepository->delete($objCategory);
    }
}
