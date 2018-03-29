<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace home\app\controller;

//use Queryyetsimple\Mvc\Controller;

use Queryyetsimple\Support\Type;
use Qys\Mvc\Controller;
use Queryyetsimple\Url;

function test() {

}

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
        print_r([
            'php_version' => PHP_VERSION,
            'swoole_version' => extension_loaded('swoole') ? phpversion('swoole') : 'Not installed Or It installed but not running.',
            'queryyetsimple_version' => extension_loaded('queryyetsimple') ? phpversion('queryyetsimple') : 'Not Installed.',
        ]);
    }

    public function tests(){
        return 'I am test!';
    }

    public function coroutineMysql() {
        go(function () {
            \co::sleep(0.5);
            echo "hello";
        });

        go('home\app\controller\test');
        go([$this, 'testMysql']);
    }

    protected function testMysql() {
        $mysql = new \Swoole\Coroutine\MySQL();
        
        $res = $mysql->connect([
            'host' => '127.0.0.1', 
            'user' => 'root', 
            'password' => '123456', 
            'database' => 'dhb_data_2'
        ]);

        if ($res == false) {
            return 'MySQL connect fail!';
        }

        $ret = $mysql->query('select sleep(1)');

        echo 'swoole response is ok, result=' . var_export($ret, true);
    }
}
