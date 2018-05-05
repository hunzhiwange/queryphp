<?php declare(strict_types=1);
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

        dd(class_exists('Leevel\Http\Response'));

        exit();

        //echo \Leevel\Hello::say();
        //throw new \Exception('i am is!');

        //return;

        //$client = new \Queryyetsimple\Client\Rpc;

        //dd($client);
        //
        
        // 引入客户端文件
        //require_once __DIR__ . "/Thrift/ClassLoader/ThriftClassLoader.php";
        // use Thrift\ClassLoader\ThriftClassLoader;
        // use Thrift\Protocol\TBinaryProtocol;
        // use Thrift\Transport\TSocket;
        // use Thrift\Transport\TFramedTransport;

        // $loader = new ThriftClassLoader();
        // $loader->registerNamespace('Thrift', __DIR__);
        // $loader->registerNamespace('Swoole', __DIR__);
        // $loader->registerNamespace('Services', __DIR__);
        // $loader->registerDefinition('Services',  __DIR__);
        // $loader->register();

        $socket = new \Thrift\Transport\TSocket("127.0.0.1", 8099);
        $transport = new \Thrift\Transport\TFramedTransport($socket);
        $protocol = new \Thrift\Protocol\TBinaryProtocol($transport);
        $transport->open();
echo PHP_VERSION;
    
        $client = new \Queryyetsimple\Protocol\Thrift\Service\ThriftClient($protocol);
        $message = new \Queryyetsimple\Protocol\Thrift\Service\Request(array('send_uid' => 350749960, 'name' => 'rango'));
        $ret = $client->call($message);
        dd($ret);

        $transport->close();

        exit();

        dump(class_exists('Thrift\Server\TServerSocket'));

        print_r([
            'php_version' => PHP_VERSION,
            'swoole_version' => extension_loaded('swoole') ? phpversion('swoole') : 'Not installed Or It installed but not running.',
            'queryyetsimple_version' => extension_loaded('queryyetsimple') ? phpversion('queryyetsimple') : 'Not Installed.',
        ]);
    }

    public function tests(){
        return 'I am test33吞吞吐吐拖拖不hhhhhhhhh!';
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
