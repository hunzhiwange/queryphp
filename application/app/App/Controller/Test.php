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

namespace App\App\Controller;

use Leevel\Page\Page;
use Leevel\Page\PageFactory;

class Hello
{
    public function __construct()
    {
        echo 'start';
    }

    public function des()
    {
        echo 'end';
    }
}

/**
 * 首页.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
class Test
{
    public function page()
    {
        echo app('page')->make(10, 500)->render();

        // $pagef = new PageFactory(app('url'));

        // echo $pagef->make()->render();

        // $page = new Page(20, 50);

        // $page->renderOption('css', sprintf(
        //     '<style type="text/css">%s</style>',
        //     file_get_contents(path().'/common/ui/page/defaults.css')
        // ));

        // // Page::setUrlResolver(function () {
        // //     return call_user_func_array([
        // //         app('url'),
        // //         'make',
        // //     ], func_get_args());
        // // });

        // //print_r($page);
        // //

        // echo $page->render();
        exit();
    }

    /**
     * 默认方法.
     */
    public function handle()
    {
        // $serv = app('swoole.websocket.server');

//   $serv->task("taskcallback", -1, function (\swoole_server $serv, $task_id, $data) {
//     echo "Task Callback: ";
//     var_dump($task_id, $data);
// });

       // \Leevel\Cookie::set('hellf','bar');
        //throw new \Exception('111111');
     // return   $re =  app('response')->redirectRaw('http://qcoroutine.cn/')->setCookie('kee', 'xx');
        //print_r(￥)
       // return 'hello';
    }

    public function handle2()
    {
        return ['hello222222222'];
        // $event = app('event');
        //$event->run(new \Common\Domain\Event\Test('hello blog'), 1, 2, 3, 4);

       // $event->run(new \Common\Domain\Event\WildcardsTest(), 2, 3);

        //return app('response')->json(['hello', 'world']);

    //   print_r(app('cache'));
     //  print_r(app('cache'));
      // print_r(app());
       // app()->make();
        //
        //return ['222','333'];
    }
}
