<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Leevel\Database\Proxy\Db;

/**
 * 查询数据库.
 *
 * @codeCoverageIgnore
 */
class Database
{
    /**
     * 默认方法.
     */
    public function handle(): array
    {
        return ['count' => Db::connect('common')->table('test')->findCount()];
    }
}
