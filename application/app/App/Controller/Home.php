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

use Common\Domain\Entity\Test;
use Common\Infra\Repository\Test as TestRe;
//use Common\Domain\Model\Test;
use Leevel;
use Leevel\Cache;
use Leevel\Db;
use Leevel\Mvc\Controller;
use Leevel\Page\Page;
use Leevel\Seccode\Seccode;
use Leevel\Session;

/**
 * 首页.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
class Home // extends Controller
{
    /**
     * 默认方法.
     */
    public function show(TestRe $hello)
    {
        //Session::set('xx','xx');
        // Session::flash('xxx','xx');

        //var_dump(app('session')->all());
        // var_dump(Leevel::pathRuntime('session'));
//         //Session::save();
        // var_dump(Leevel::make('cookie'));
        //var_dump(Leevel::flash(['foo' => 'bar']));
        var_dump(Leevel::cache('foo/bar', ['foo' => 'bar']));
        // var_dump(app('session'));
        return;
        //  $seccode = new \Leevel\Seccode\Seccode([
        //      'background_path' => __DIR__.'/background',
        //      'font_path'       => __DIR__.'/font',
        //      'chinese_font_path' =>__DIR__.'/cnfont',
        //  ]);

        // // $file = __DIR__.'/baseuse.png';

        //  $seccode->display('abc');
        //exit();
        // Cache::set('hello', 'world');

        // var_dump(Cache::get('hello'));

        // $page = new Page(null, null);

        // $page->currentPage((int) $_GET['page']);

        // $page->range(3);

        // $page->renderOption('css', false);

        // Page::setUrlResolver(function () {
        //     //var_dump(func_get_args());
        //     //exit();
        //     return call_user_func_array([
        //         app('url'),
        //         'make',
        //     ], func_get_args());
        // });

        //print_r($page);
        //

        // echo $page->render();
        exit();

        // (new Seccode([
        //     'width' => 120,
        //     'height' => 36,
        //     'background_path' => path().'/common/ui/seccode/background',
        //     'font_path' => path().'/common/ui/seccode/font',
        // ]))->display(4, true);

        return;
//       echo "初始: ".($start = memory_get_usage()/1000)."B\n";
//       for($i=0; $i<=1000000;$i++){
//         $test = new Test(['name'=>'xx']);
//       }
//       echo "使用: ".($end = memory_get_usage()/1000)."B\n";
//       echo "use: ".(($end-$start)/1000)."B\n";
        // //8.382168
        // //8.384816
//       exit();
        $test = new Test(['name'=>'xx']);

        // $test->xxxxx = 'xxx';
        //$test->setNikeName('222');
        //dd($test::STRUCT);
        // dd($test);
        $test->save();

        $test->flush();

        $test->forceProp('name', 'xxxxxxxxx');

        $test->save();

        $test->flush();
        dd($test);
        //var_dump($hello);

        // $hello->registerCreate($test);

        // $hello->
        //
        //$hello->registerCommit();
        //print_r($hello);
        exit();
        // print_r(Db::table('test')->getAll());
        //     throw new \Exception('111');
        return ['hello'];
        // dd('' == false);
        // dd(0 == '');
        // dd(0.0=='');
        // dd("0"=='');
        // dd(0.0==NULL);
        // dd(0.0==FALSE);
        // dd(0.0=='');
        // "" (空字符串)
        // 0 (作为整数的0)
        // 0.0 (作为浮点数的0)
        // "0" (作为字符串的0)
        // NULL
        // FALSE
        // array() (一个空数组)
        // $var; (一个声明了，但是没有值的变量)
        //exit();
        //  app('log')->info('hello', ['hello', 'world'], true);

        // $parser = (new \Leevel\View\Parser(new \Leevel\View\Compiler))->

        // registerCompilers()->

        // registerParsers();

        // dd($parser->doCombile('/data/codes/queryphp/hello.html'));

        // exit();
        //dump(db::table('test')->getAll(true));
        //exit();
        return $this->display('home');
    }
}
