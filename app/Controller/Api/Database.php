<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Domain\Entity\Demo\Test;
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
        echo 11;
        // $test = new Test();
        /** @var Test $demo */
        $demo = Test::select()->findEntity(1);
        //   print_r($demo);
        //  $demo->createAt = 'xxxxx';
        print_r($demo);
        // $demo->fields();
        exit;

        return ['count' => Db::table('test')->findCount()];
    }
}
