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

use common\domain\entity\user as aggregate;
use common\domain\repository\user as user_repository;
use queryyetsimple\mvc\repository;

/**
 * 用户帐号（聚合根）实现.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.12
 *
 * @version 1.0
 */
class user extends repository implements user_repository
{
    /**
     * 后台菜单聚合根.
     *
     * @var \common\domain\entity\user
     */
    protected $oAggregate;

    /**
     * 构造函数.
     *
     * @param \common\domain\entity\user $objAggregate
     */
    public function __construct(aggregate $objAggregate)
    {
        parent::__construct($objAggregate);
    }
}
