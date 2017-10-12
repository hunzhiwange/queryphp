<?php

namespace home\application\controller;

use queryyetsimple\mvc\controller;
use queryyetsimple\session;
use queryyetsimple\http\request;
use queryyetsimple\bootstrap\validate\request as validate_request;

class index extends controller {

    use validate_request;

    /**
     * 默认方法
     *
     * @return void
     */
    public function index(request $oRequest) {
       // echo path_file_cache();
       
        //print_r($oRequest);
         session::start();

         session::setPrevUrl('http://queryphp.cn/?a=show');
        
         $this->validate($oRequest, [
            'title' => 'required|max:255|must',
             'body' => 'required|must',
         ]);

      //  print_r($_SESSION);
        //$this->display ();
    }
    
    public function show(){
        session::start();
        print_r($_SESSION);
    }

    public function yes(request $xx,$what){
    }

}
