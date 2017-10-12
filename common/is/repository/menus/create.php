<?php
namespace admin\is\repository\menus;

use Exception;
use admin\domain\repository\menus\create as repository;
use admin\domain\aggregation\menus\create as aggregation;
use admin\domain\repository\menus\exception\create_failed;

class  create implements repository {

    protected $oAggregation;

    public function __construct(aggregation $oAggregation){
       $this->oAggregation = $oAggregation;
    }
    
    public function run(){
      return $this->oAggregation->setRepository( $this );
    }

    public function queryListMenu(){
      try {
         return $this->oAggregation->entity()->orderBy('sort')->getAll();
      } catch (Exception $oE) {
         throw new index_failed($oE->getMessage());
      }
    }

    public function topMenu(){
      return ['id' => -1, 'pid' => 0, 'lable' =>  '选择父级菜单'];
    }
}
