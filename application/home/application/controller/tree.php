<?php

namespace home\application\controller;

use queryyetsimple\mvc\controller;
use qys\log;
use queryyetsimple\auth\manager;
use qys\auth;
use qys\session;
use common\domain\model\admin_menu;
use queryyetsimple\support\tree as trees;

class tree extends controller {

    /**
     * 默认方法
     *
     * @return void
     */
    public function index() {
        $arrList = admin_menu::getAll();
        $arrNode = [];
        foreach($arrList as $arr){
            $arrNode[] = [$arr['id'],$arr['pid'],$arr->toArray() ];
        }

        $oTree = new trees( $arrNode);
       // print_r($oTree);
        print_r($oTree->toJson(256 ,function($arrItem,$oTree){
            $arrNew = $arrItem['data'];
            return $arrNew;
        },['children'=>'child']));
        //var_dump($oTree->getNodeLever(0));

       // echo json_encode($oTree->toArray2(),JSON_UNESCAPED_UNICODE);

        echo 'tree';
        //$
        //return $this->display ();
    }
    
    public function show(){
    }

    public function yes(request $xx,$what){
    }

}
