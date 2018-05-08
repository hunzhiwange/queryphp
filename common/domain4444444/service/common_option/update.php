<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\domain\service\common_option;

use common\is\repository\common_option as repository;

/**
 * 后台配置更新服务
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class update
{

    /**
     * 后台配置仓储
     *
     * @var \common\is\repository\common_option
     */
    protected $oRepository;

    /**
     * 配置信息
     *
     * @var array
     */
    protected $arrOption = [];

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
     * @param array $arrOption
     * @return void
     */
    public function run(array $arrOption)
    {
        $this->arrOption = $arrOption;
        $this->registerUnitOfWork($this->queryOption(array_keys($arrOption)));
        $this->commit();
    }

    /**
     * 注册工作单元
     *
     * @param \queryyetsimple\support\collection $objCollection
     * @return void
     */
    protected function registerUnitOfWork($objCollection)
    {
        foreach ($objCollection as $objOption) {
            $objOption->forceProp('value', $this->arrOption[$objOption->name]);
            $this->oRepository->registerUpdate($objOption);
        }
    }

    /**
     * 提交工作单元
     *
     * @return void
     */
    protected function commit()
    {
        $this->oRepository->registerCommit();
    }

    /**
     * 查找指定配置
     *
     * @param array $arrOptionKey
     * @return \queryyetsimple\support\collection
     */
    protected function queryOption(array $arrOptionKey)
    {
        return $this->oRepository->all(function ($oSelect) use ($arrOptionKey) {
            $oSelect->where('name', 'in', $arrOptionKey)->setColumns('id,name');
        });
    }
}
