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

namespace common\is\repository;

use common\domain\entity\common_option as aggregate;
use common\domain\repository\common_option as common_option_repository;
use queryyetsimple\mvc\repository;

/**
 * 公共配置（聚合根）实现.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
class common_option extends repository implements common_option_repository
{
    /**
     * 后台菜单聚合根.
     *
     * @var \common\domain\entity\common_option
     */
    protected $oAggregate;

    /**
     * 构造函数.
     *
     * @param \common\domain\entity\common_option $objAggregate
     */
    public function __construct(aggregate $objAggregate)
    {
        parent::__construct($objAggregate);
    }
}
