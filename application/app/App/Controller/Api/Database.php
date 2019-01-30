<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\App\Controller\Api;

use Leevel\Db;

/**
 * 查询数据库.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.08
 *
 * @version 1.0
 */
class Database
{
    /**
     * 默认方法.
     *
     * @return array
     */
    public function handle(): array
    {
        return ['count' => Db::table('test')->findCount()];
    }
}
