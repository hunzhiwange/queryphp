<?php
/*
 * [$MyApp] (C)QueryPHP.COM Since 2016.11.19.
 * 默认配置文件
 *
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.11.19
 * @since 1.0
 */
// use Q, Q\base\action;

// use Q\base\action;

// class test {
// public function __construct(){

// }
// public function index($that){
// echo 'Hello index';
// $that->assign('hello','Hello index');
// print_r($that->in);
// $that->display();
// }
// }

// $oTest =new test();
// Q::app()->registerController('hello', array($oTest,'index'));

// // Q::app()->registerController('hello3', function($that){
// // //return 'xxxxxxxx';
// // //echo 'xxxxxxxxxxxx';
// // //print_r($that);
// // //vard
// // // var_dump($this);
// // $this->assign('xxx','xxx');
// // echo 'sdfsdfs';
// // exit();
// // $this->display();
// // });

// //Q::app()->registerController('hello3', $oTest);

// //Q::app()->registerController('hello3', ['XXX'=>'xxx','sdfsdf'=>'xxx']);

// /**
// * 默认控制器
// *
// * @since 2016年11月19日 下午1:41:35
// * @author dyhb
// */
// class test2 extends action {
// public function run(){
// echo 'test';
// }
// }

// Q::app()->registerController('hello3', new test2());

/*
 * return [
 * 'i18n_default' => 'en-us',
 * 'i18n_on' => true, // 是否使用语言包
 * 'i18n_switch' => true,
 * 'show_page_trace' => true,
 *
 * 'theme_default' => 'blue',
 * 'theme_cache_children' => true,
 * ];
 */


// $arrHello = ['name' => '我的世界', 'description' => '我乐我生活，你享你世界'];

// 注册路由
//Q::app ()->registerAction ( 'goods', 'list', '你好，世界！');