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

namespace Common\Infra\Repository;

use Common\Domain\Entity\Test as Entity;
use Leevel\Database\Ddd\Repository;

/**
 * 事件服务提供者.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.01.29
 *
 * @version 1.0
 */
class Test extends Repository
{
    public function __construct(Entity $xx)
    {
        parent::__construct($xx);
    }
}
