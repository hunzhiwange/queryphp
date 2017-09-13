<?php
namespace admin\application\controller\abstracts;

use queryyetsimple\mvc\controller;

class common extends controller {

    public function __construct(){
        /*防止跨域*/      
        header('Access-Control-Allow-Origin: '.(isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN']: ''));
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");
    }

}

