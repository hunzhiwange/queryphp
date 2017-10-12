<?php

namespace admin\app\controller\menus;

use queryyetsimple\request;
use queryyetsimple\response;
use queryyetsimple\mvc\action;
use admin\domain\service\admin_menu\edit as edits;
use queryyetsimple\support\helper;
use admin\domain\value_object\admin_menu;

class edit extends action {

    public function run(edits $oEdit) {

        echo '111';

        $oMenu = new admin_menu();

        print_r($oMenu);

        print_r($oMenu->getData('status\enabled'));

        $oMenu['xxxxx'] = '33';

        $oMenu->merge('status',['xxx' => '回收站']);
        $oMenu->helloName = '11';
        $oMenu->setHellNameVa2(222);
        $oMenu->putSource([
            'xxx' => 55,
            'xxxxx' => '22'
        ]);
        print_r($oMenu);
        exit();
        return $oEdit->run(request::all('args\0'));
    }

}
