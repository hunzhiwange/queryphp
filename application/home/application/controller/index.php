<?php

/**
 * 默认控制器文件
 */
namespace home\application\controller;

use Q\mvc\controller;
// use home\infrastructure\provider;
// use home\domain\model\test;
// use Q\traits\test as test2;
// use Q\exception\exception;

class index extends controller {
    
    // public function __construct( $test){
    // print_r($test);
    // }
    
    // public function __construct(test_provider $test ){
    // print_r($test);
    // }
    
    /**
     * 默认方法
     *
     * @return void
     */
    public function index() {
        //echo 'test';
     //   test2::xxxx();
     
      //  exception::throws('dsfsdf222');
      
       //echo \Q\cookie\cookie::clears();
       
       // print_r() \Q::database()->wher;
        
       // echo 'hello world';
        
      //  $obj = new test([ 'id2' =>35, 'name' => 'hello', 'value' => '222222','ge' => 'xxxx','create_int' =>'22' ]);
      //  $obj->value = '22222222222222222222222';
      
        //$obj->changeProp('xxx',5);
        
       // print_r($obj->save());
       
       // print_r( \Q::database()->connect()->table('test')->getAll() );
        
      // print_r( \Q\database\database::table('test')->getAll() ) ;
       
        //echo 'xx';
        //$this->assign('xxx',55);
       // $this->display();
       // echo '1234';
        
         //\Q\database\test::xxx();
        $this->display();
        exit();
    }
}
