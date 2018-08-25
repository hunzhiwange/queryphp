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

namespace common\domain\service\common_option;

use common\is\repository\common_option as repository;

/**
 * 后台配置更新服务
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class update
{
    /**
     * 后台配置仓储.
     *
     * @var \common\is\repository\common_option
     */
    protected $oRepository;

    /**
     * 配置信息.
     *
     * @var array
     */
    protected $arrOption = [];

    /**
     * 构造函数.
     *
     * @param \admin\is\repository\admin_menu $oRepository
     */
    public function __construct(repository $oRepository)
    {
        $this->oRepository = $oRepository;
    }

    /**
     * 响应方法.
     *
     * @param array $arrOption
     */
    public function run(array $arrOption)
    {
        $this->arrOption = $arrOption;
        $this->registerUnitOfWork($this->queryOption(array_keys($arrOption)));
        $this->commit();
    }

    /**
     * 注册工作单元.
     *
     * @param \queryyetsimple\support\collection $objCollection
     */
    protected function registerUnitOfWork($objCollection)
    {
        foreach ($objCollection as $objOption) {
            $objOption->forceProp('value', $this->arrOption[$objOption->name]);
            $this->oRepository->registerUpdate($objOption);
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
     * 查找指定配置.
     *
     * @param array $arrOptionKey
     *
     * @return \queryyetsimple\support\collection
     */
    protected function queryOption(array $arrOptionKey)
    {
        return $this->oRepository->all(function ($oSelect) use ($arrOptionKey) {
            $oSelect->where('name', 'in', $arrOptionKey)->setColumns('id,name');
        });
    }
}
