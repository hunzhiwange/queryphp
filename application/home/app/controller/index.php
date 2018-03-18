<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace home\app\controller;

//use Queryyetsimple\Mvc\Controller;

use Queryyetsimple\Support\Type;
use Qys\Mvc\Controller;
use Queryyetsimple\Url;

/**
 * index 控制器
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class index extends Controller
{

    /**
     * 默认方法
     *
     * @return void
     */
    public function index()
    {

        echo 'test';

        print_r($_GET);

        //Cache::set('ss','222');

       // $url = app('url');

        //echo url('test/hello?arg1=1&arg2=3');


        //$event = app('event');
        //$event->run('common\domain\event\WildcardsTest', 1, 2, 3, 4);
        
        //\Qys\Log::error('1111');
        // $app = app();

        // $ello = $app->share(function($a){
        //     echo $a;
        //     return $a;
        // });

        // print_r($ello(5));$ello(5);$ello(5);$ello(5);$ello(5);$ello(5);

        /// app()->share();

        // aop_before('home\app\controller\hello2->beforetest',function($b)  {
        //     echo 'hello before';
        //     $this->checkAccess();
        // });

        // aop_before('home\app\controller\hello2->beforetest',function($b)  {
        //     echo 'hello before2';
        // });

        // aop_before('home\app\controller\hello2->beforetest',function($b)  {
        //     echo 'hello before3';
        // });

        // exit();

        // $hello = new hello();
        // //echo 'hello_world';
        // $hello->testBeforAdd1();
        // exit();
        //echo 'hello world';
        // return $this->display('test2+hello',['navigation' => [
        //     ['item'=>'33','caption'=>'333'],
        //     ['item'=>'33','caption'=>'5']
        // ]]);
        
        //echo 'hello';
    }

    public function test2(){
        return 'lm';
    }
}
