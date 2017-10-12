<?php

namespace admin\app\controller\menus;

use queryyetsimple\mvc\action;
use admin\is\repository\hello as oRepository;


class helloupdate extends action {

    public function run(oRepository $oRepository) {
        //echo 'hellow rold';
        $idea = $oRepository->find(52);

        $idea->url = 'xxxxx';

        return $oRepository->update($idea);
    }

}