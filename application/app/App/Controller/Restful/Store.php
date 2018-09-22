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

namespace App\App\Controller\Restful;

use Leevel\Router\IRouter;

/**
 * store.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2018.07.20
 *
 * @version 1.0
 */
class Store
{
    public function handle()
    {
        return 'hello for restful '.IRouter::RESTFUL_STORE;
    }
}
