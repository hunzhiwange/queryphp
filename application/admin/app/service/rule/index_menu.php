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

namespace admin\app\service\rule;

use queryyetsimple\router\router;

/**
 * 首页、菜单合并请求服务
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.15
 *
 * @version 1.0
 */
class index_menu
{
    /**
     * 路由.
     *
     * @var \queryyetsimple\router\router
     */
    protected $oRouter;

    /**
     * 构造函数.
     *
     * @param \queryyetsimple\router\router $oRouter
     */
    public function __construct(router $oRouter)
    {
        $this->oRouter = $oRouter;
    }

    /**
     * 响应方法.
     *
     * @param array $arrApiMulti
     *
     * @return array
     */
    public function run(array $arrApiMulti)
    {
        return $this->oRouter->doBindMulti($arrApiMulti);
    }
}
