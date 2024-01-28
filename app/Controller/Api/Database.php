<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Leevel\Database\Proxy\Db;
use Swoole\Coroutine\Barrier;
use Swoole\Coroutine;

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
       // go(function() {
       //     $x = Db::table('test')->findCount();
       // });
       //  go(function() {
       //      $x1 = Db::table('test')->findCount();
       //  });
       //  go(function() {
       //      $x2 = Db::table('test')->findCount();
       //  });

        // $barrier = Barrier::make();
        //
        // $count = 0;
        // $N = 4;
        // $result = [];
        //
        // foreach (range(1, $N) as $i) {
        //     Coroutine::create(function () use ($barrier, &$count, &$result) {
        //         //sleep(1);
        //         $result[] = Db::table('test')->findCount();
        //         $count++;
        //     });
        // }
        //
        // Barrier::wait($barrier);

        Db::transaction(function() {
           Db::table('test')->where('id',5)->find();
           Db::table('test')->insert(['name' => 'neww']);
            Db::table('test')->insert(['name' => 'new33w222']);
        });

        return ['count' => 1111];
    }
}
