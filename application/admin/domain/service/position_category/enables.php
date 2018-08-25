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

namespace admin\domain\service\structure;

use admin\is\repository\structure as repository;

/**
 * 后台部门启用禁用服务
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class enables
{
    /**
     * 后台部门仓储.
     *
     * @var \admin\is\repository\structure
     */
    protected $oRepository;

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
     * @param int    $intId
     * @param string $strType
     * @param mixed  $arrId
     * @param mixed  $strStatus
     */
    public function run($arrId, $strStatus)
    {
        $this->checkStatus($strStatus);
        $this->registerUnitOfWork($this->queryStructures($arrId), $strStatus);
        $this->commit();
    }

    /**
     * 验证启用禁用状态
     *
     * @param string $strStatus
     */
    protected function checkStatus($strStatus)
    {
        if (!in_array($strStatus, [
            'disable',
            'enable',
        ], true)) {
            throw new enables_failed(__('启用禁用状态不受支持'));
        }
    }

    /**
     * 注册工作单元.
     *
     * @param \queryyetsimple\support\collection $objCollection
     * @param string                             $strStatu
     * @param mixed                              $strStatus
     */
    protected function registerUnitOfWork($objCollection, $strStatus)
    {
        foreach ($objCollection as $objStructure) {
            $objStructure->forceProp('status', $strStatus);
            $this->oRepository->registerUpdate($objStructure);
        }
    }

    /**
     * 提交工作单元.
     */
    protected function commit()
    {
        $this->oRepository->registerCommit();
    }

    /**
     * 查找指定 ID 的部门.
     *
     * @param array $arrIds
     *
     * @return \queryyetsimple\support\collection
     */
    protected function queryStructures(array $arrIds)
    {
        return $this->oRepository->all(function ($oSelect) use ($arrIds) {
            $oSelect->where('id', 'in', $arrIds)->setColumns('id');
        });
    }
}
