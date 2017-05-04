<?php
/**
 * 路由配置文件
 */
return [ ];

// class mmm{
    
// }

// class xxxx{

// }



//use home\application\controller\index as homeIndex;


// class teset{
    
//     public function run(){
//         echo 'xx';
//     }
    
// }

// \Q::router()->bind( 'hello', new teset());

$calHello = function( ){
    \Q::throwException('X');
    echo 'xx';
    //$this->assign ( 'strSay', '数组匿名函数' );
    //$this->display ();
};

// 注册路由
\Q::router()->bind ( 'hello',  ['index' => $calHello]);

// use home\infrastructure\test_provider;

// \Q::project()->register('home\infrastructure\test_provider');

// class helloworld {
    
//     public static $xxx;
    
//     public function __construct(mmm $xxx,$xx,xxxx $that,test_provider $xxxxxxxx){
//    // self::$xxx = $xxx;   
    
//         //print_r($xxxxxxxx);
//         //print_r($xxx);
//     }

//     /**
//      * 返回 say
//      *
//      * @return string
//      */
//     public static function getSay(xxxx $that) {
//        // self::
//         print_r($that);
        
//        // $that->assign ( 'strSay', '静态回调' );
//        // $that->display ();
       
//         echo 'xxx';
//     }
// }

// //注册路由
// \Q::router()->bind ( 'hello', [ 
//         'helloworld',
//         'getSay' 
// ] );
