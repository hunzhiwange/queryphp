<?php
namespace admin\domain\service\admin_menu;

use queryyetsimple\support\tree;
use common\domain\model\admin_menu;

class lists_tree {

    protected $oMenu;

    public function __construct(admin_menu $oMenu){
        $this->oMenu = $oMenu;
    }

    public function run(){
        $arrNode = [];
        foreach($this->oMenu->orderBy('sort')->getAll() as $oMenu){
          $arrNode[] = [$oMenu->id,$oMenu->pid,$oMenu->title ];
        }
    
        $oTree = new tree( $arrNode);
        return $oTree->toArray( function($arrItem){
            return [
                'id' => $arrItem['value'],
                'label' => $arrItem['data'],
            ];
        });
    }

}
