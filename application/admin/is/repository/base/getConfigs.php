<?php
namespace admin\is\repository\base;

use Exception;
use admin\domain\repository\base\getConfigs as repository;
use admin\domain\aggregation\base\getConfigs as aggregation;
use admin\domain\repository\base\exception\getConfigs_failed;

class  getConfigs implements repository {

    protected $oAggregation;

    public function __construct(aggregation $oAggregation){
       $this->oAggregation = $oAggregation;
   }
    
    public function run(){
      return $this->oAggregation->setRepository( $this );
    }

    public function queryOption(){
      try {
        return $this->oAggregation->entity()->setColumns('name,value')->getAll();
      } catch (Exception $oE) {
         throw new getConfigs_failed($oE->getMessage());
      }
    }
}
