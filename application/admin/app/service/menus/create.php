<?php

namespace admin\app\service\menus;

use admin\is\repository\menus\create as repository;

class create {

    protected $oRepository;

    public function __construct(repository $oRepository){
        $this->oRepository = $oRepository;
    }

    public function run($intParentId = null) {
        $oAggregation = $this->oRepository->run();
        
        return $oAggregation->menuSelect($intParentId);
    }

}