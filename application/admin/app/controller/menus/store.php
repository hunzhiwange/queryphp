<?php

namespace admin\app\controller\menus;

use queryyetsimple\request;
use queryyetsimple\response;
use queryyetsimple\mvc\action;
use admin\domain\service\admin_menu\store as stores;
use admin\domain\service\admin_menu\exception\store_failed;

class store extends action {

    public function run(stores $oStores) {
        try {
            $oStores->run(request::alls(['menu|trim','module|trim','pid','sort|intval','title|trim','url|trim']));
            return [ 'message' => '菜单保存成功' ];
        } catch (store_failed $oE) {
            return response::apiError($oE->getMessage());
        } 
    }

}
