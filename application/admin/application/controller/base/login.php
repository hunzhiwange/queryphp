<?php

namespace admin\application\controller\base;

use queryyetsimple\mvc\action;
use queryyetsimple\bootstrap\auth\login_api as auth_login_api;
use queryyetsimple\http\request;
use queryyetsimple\support\tree;
use common\domain\model\admin_menu;

class login extends action {

    use auth_login_api;

    public function run(request $oRequest) {
        //return [];
        //return $oGet->run();
       // print_r($_POST);
       // return $this->checkLogin($oRequest);
   // print_r($oRequest->allAll());

    //exit();
       //$_POST['name'] = $oRequest->all('username');

       $arrData = $this->checkLogin($oRequest);
       $arrData['menusList'] = $this->getMenu();
       $arrData['authList'] = $this->getAuth();

       return $arrData;
    }

    public function getAuth(){

    }

    public function getMenu(){
        $arrList = admin_menu::getAll();
        $arrNode = [];
        foreach($arrList as $arr){
            $arrNode[] = [$arr['id'],$arr['pid'],$arr->toArray() ];
        }

        $oTree = new tree( $arrNode);
       // print_r($oTree);
        return $oTree->toArray(function($arrItem,$oTree){
            $arrNew = $arrItem['data'];
            return $arrNew;
        },['children'=>'child']);
    }

}