<?php
namespace admin\is\repository\menus;

use Exception;
use admin\domain\repository\menus\index as repository;
use admin\domain\aggregation\menus\index as aggregation;
use admin\domain\repository\menus\exception\index_failed;

class  index implements repository {

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
}
