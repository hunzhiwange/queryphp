<?php
use Q\router\router;

use home\factory\test;

// 匿名函数回调
// router::bind ( 'hello', function( test $objTest){
//     $this->assign ( 'strSay', '匿名函数' );
//     $this->display ();
// } );

class test22{
    public function run(test $objTest){
        //echo 'sdf';
        //eco 'sdf';
        
       // echo 'sdfffffffffffffffffffffff';
       
         $objTest->test();
    }
}
$test = new test22();
router::bind ( 'hello', [$test,'run']);


// router::import ( '/', 'home://topic/show' );
// router::import ( 'hello-{what}/{ssss}', 'home://topic/index');

// router::bind('home://hello', function( ){
// $this->assign ( 'strSay', '匿名函数' );
// $this->display ();
// } );

// // 用法1
// router::regex ( 'id', '[0-9]+' );

// // 用法2
// router::regex ( [
// 'name',
// '[a-z]+'
// ] );

// // 用法3
// router::regex ( [
// 'id' => '[0-9]+',
// 'name' => '[a-z]+'
// ] );

// // 用法1
// router::import ( 'new-{id}', 'home://new/index', [
// 'where' => [
// 'id',
// '[0-9]+'
// ]
// ] );

// // // 用法2
// router::import ( 'new-{id}', 'home://index/index', [ 
//         'where' => [ 
//                 'id' => '[0-9]+' 
//         ] ,'domain' =>'{domain}'
// ] );

// // 用法3
// router::import ( 'new-{id}-{name}', 'home://new/index', [
// 'where' => [
// 'id' => '[0-9]+',
// 'name' => '[a-z]+'
// ]
// ] );

// router::group ( [
// 'prefix' => 'myprefix-'
// ], function () {
// router::group ( [
// 'params' => [
// 'args1' => '你',
// 'args2' => '好'
// ]
// ], function () {
// router::import ( 'new-{id}-{name}', 'home://new/index' );
// router::import ( 'hello-{goods}', 'home://goods/index' );
// } );
// } );

// router::bind ( '/', [
// 'index' => 'Hello Hello'
// ] );

// router::domain('hello','home://index/hello');

// router::import ( 'new-{id}-{name}', 'home://new/index',['domain' => 'hello'] );

// router::domain('world.queryphp.cn','home://index/world');

// router::import ( 'hello-{what}', 'home://topic/index', [
// 'domain' => 'hello'
// ]);

// router::domain ( 'hello', function () {
// router::import('hello-{what}', 'home://topic/index');
// } );

// router::domain ( 'hello', function () {
// router::group ( [
// 'prefix' => 'myprefix-'
// ], function () {
// router::import ( 'hello-{what}', 'home://topic/index' );
// } );
// } );

// IP绑定到admin模块
// router::domain('127.0.0.1','local');

/**
 * 路由配置文件
 */

// return [

// [ 'hello222-{what}/{ssss}', 'home22://topic/index']

// ];

// router::regexDomain(['domain' => '[a-z]+']);

// router::domain ( '{domain}', 'home://index/index', [ 
//         'domain_where' => [ 
//                 'domain' => '[a-z]+' 
//         ] 
// ] );

// return [
//     '~domains~' => [
//        ['hello', 'home://index/index'],
//        ['hello.queryphp.cn', 'home://index/index' ]
//     ],
// ];
