<?php

namespace admin\app\service\base;

use admin\is\repository\base\getConfigs as repository;

class getConfigs {

    protected $oRepository;

    public function __construct(repository $oRepository){
        $this->oRepository = $oRepository;
    }

    public function run() {
        $oAggregation = $this->oRepository->run();
        
        return $oAggregation->option();
    }

}