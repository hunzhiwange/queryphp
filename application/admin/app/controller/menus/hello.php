<?php

namespace admin\app\controller\menus;

use queryyetsimple\mvc\action;
use admin\is\repository\hello as oRepository;


class hello extends action {

    public function run(oRepository $oRepository) {
        echo 'hellow rold';
        $idea = $oRepository->find(52);
//https://github.com/culttt/cribbb/tree/a44691165ab0324cdc7dc2ae93ff391d4511ef5b/app/Application
        print_r($idea);
    }

}