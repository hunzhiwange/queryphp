<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\rule;

use queryyetsimple\router\router;

/**
 * 首页、菜单合并请求服务
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.15
 * @version 1.0
 */
class index_menu
{

    /**
     * 路由
     *
     * @var \queryyetsimple\router\router
     */
    protected $oRouter;

    /**
     * 构造函数
     *
     * @param \queryyetsimple\router\router $oRouter
     * @return void
     */
    public function __construct(router $oRouter)
    {
        $this->oRouter = $oRouter;
    }

    /**
     * 响应方法
     *
     * @param array $arrApiMulti
     * @return array
     */
    public function run(array $arrApiMulti)
    {
        return $this->oRouter->doBindMulti($arrApiMulti);
    }
}
