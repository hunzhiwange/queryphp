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

namespace admin\app\service\position;

use admin\is\repository\admin_position as repository;
use queryyetsimple\mvc\model_not_found;

/**
 * 后台职位状态更新.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class enable
{
    /**
     * 后台职位仓储.
     *
     * @var \admin\is\repository\admin_position
     */
    protected $oRepository;

    /**
     * 构造函数.
     *
     * @param \admin\is\repository\admin_position $oRepository
     */
    public function __construct(repository $oRepository)
    {
        $this->oRepository = $oRepository;
    }

    /**
     * 响应方法.
     *
     * @param int    $intId
     * @param string $strStatus
     *
     * @return array
     */
    public function run($intId, $strStatus)
    {
        return $this->oRepository->update($this->entify($intId, $strStatus));
    }

    /**
     * 验证参数.
     *
     * @param int    $intId
     * @param string $strStatus
     *
     * @return \admin\domain\entity\admin_position
     */
    protected function entify($intId, $strStatus)
    {
        $objStructure = $this->find($intId);
        $objStructure->forceProp('status', $strStatus);

        return $objStructure;
    }

    /**
     * 查找实体.
     *
     * @param int $intId
     *
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
