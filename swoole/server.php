<?php 
//require_once __DIR__ . "/../vendor/apache/thrift/lib/php/lib/Thrift/ClassLoader/ThriftClassLoader.php";
require_once './../vendor/autoload.php';
use Thrift\ClassLoader\ThriftClassLoader;
use Thrift\Server\TServerSocket;
$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', __DIR__);
$loader->registerNamespace('Swoole', __DIR__);
$loader->registerNamespace('Services', __DIR__);
$loader->registerDefinition('Services',  __DIR__);
$loader->register();
$service = new Services\HelloSwoole\Handler();
$processor = new Services\HelloSwoole\HelloSwooleProcessor($service);
$socket_tranport = new TServerSocket('0.0.0.0', 8091);
$out_factory = $in_factory = new Thrift\Factory\TFramedTransportFactory();
$out_protocol = $in_protocol = new Thrift\Factory\TBinaryProtocolFactory();
$server = new Swoole\Thrift\Server($processor, $socket_tranport, $in_factory, $out_factory, $in_protocol, $out_protocol);
$server->serve();

echo '33';