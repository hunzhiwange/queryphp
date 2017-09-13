<?php

namespace admin\application\controller\menus;

use queryyetsimple\mvc\action;
use admin\domain\service\admin_menu\lists_tree;

class index extends action {

    public function run(lists_tree $olistsTree) {
        return $olistsTree->run();
        //echo 'xx';
    }


}