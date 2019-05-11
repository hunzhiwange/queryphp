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

namespace App\App\Controller\Home;

use Leevel\Cache\Proxy\Cache;
use Leevel\Database\Proxy\Db;
use Leevel\Filesystem\Proxy\Filesystem;
use Leevel\Router\Proxy\View;

/**
 * 首页.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
class Index
{
    /**
     * 默认方法.
     *
     * @return string
     */
    public function handle()//: string
    {
        //Filesystem::put('new.txt', 'x小十分水电费水电费xxx');
        echo 1;
        app('logs')->info('xxx', ['info', 'hello']);

        //app('caches')->set('xxx', '高级技师');
    //    $auth->setTokenName('xx');
    //    var_dump($auth->isLogin());
        // /** @var \Leevel\Filesystem\Manager @db */
        // $db = app('filesystems');

        // print_r( $db
        //     ->put(__DIR__.'/xx.php', '2222xxxx'));

        //var_dump(Db::selfSelect());
        // $x = Db::table('test')->limit(20)->findAll();
        // print_r($x);
//         Cache::set('xxxxxx', 'wwwwxx');
// dump(Cache::get('xxxxxx'));
//         $cache = app('caches');
//       $cache->put(['hello' => '222']);
// dump($cache->get('hello'));
        //return View::display('home');
    }
}
