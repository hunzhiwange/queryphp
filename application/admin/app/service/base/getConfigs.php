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

namespace admin\app\service\base;

use common\is\repository\common_option as repository;

/**
 * 后台配置.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
class getConfigs
{
    /**
     * 后台菜单仓储.
     *
     * @var \admin\is\repository\admin_menu
     */
    protected $oRepository;

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
     * @return array
     */
    public function run()
    {
        return $this->parseToMap($this->oRepository->all());
    }

    /**
     * 解析配置隐射.
     *
     * @param \queryyetsimple\support\collection $objOption
     *
     * @return array
     */
    protected function parseToMap($objOption)
    {
        $arr = [];
        foreach ($objOption as $oVal) {
            $arr[$oVal->name] = $oVal->value;
        }

        return $arr;
    }
}
