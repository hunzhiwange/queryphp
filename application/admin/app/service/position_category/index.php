<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\position_category;

use admin\domain\value_object\position_category\status;
use admin\is\repository\position_category as repository;

/**
 * 后台职位分类列表
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.18
 * @version 1.0
 */
class index
{

    /**
     * 后台职位分类仓储
     *
     * @var \admin\is\repository\position_category
     */
    protected $oRepository;

    /**
     * 职位分类状态值对象
     *
     * @var \admin\domain\value_object\position_category\status
     */
    protected $oStatus;

    /**
     * 构造函数
     *
     * @param \admin\is\repository\position_category $oRepository
     * @param \admin\domain\value_object\position_category\status $oStatus
     * @return void
     */
    public function __construct(repository $oRepository, status $oStatus)
    {
        $this->oRepository = $oRepository;
        $this->oStatus = $oStatus;
    }

    /**
     * 响应方法
     *
     * @param array $arrSearch
     * @return array
     */
    public function run(array $arrSearch)
    {
        return $this->parseList($this->oRepository->all( $this->searchCondition($arrSearch) ));
    }

    /**
     * 返回职位分类数据
     *
     * @param \queryyetsimple\support\collection $objPositionCategory
     * @return array
     */
    protected function parseList($objPositionCategory)
    {
        $arrData = [];

        foreach($objPositionCategory as $obj) {
            $obj = $obj->toArray();
            $obj['status_name'] = $this->statusName($obj['status']);
            $arrData[] = $obj;
        }

        return $arrData;
    }

    /**
     * 状态名字
     *
     * @param string $strStatus
     * @return string
     */
    protected function statusName($strStatus)
    {
        return $this->oStatus->{$strStatus};
    }

    /**
     * 组装搜索条件
     *
     * @param array $arrSearch
     * @return array
     */
    protected function searchCondition(array $arrSearch) {
        if(!$arrSearch) {
            return null;
        }

        return function($objSelect) use($arrSearch) {
            return $objSelect->

            ifs(!empty($arrSearch['key']))->whereLike('name', '%'.$arrSearch['key'].'%')->endIfs();
        };
    }
}
