<?php

namespace admin\application\controller\menus;

use queryyetsimple\request;
use queryyetsimple\response;
use queryyetsimple\mvc\action;
use admin\domain\service\admin_menu\destroy as destroys;
use admin\domain\service\admin_menu\exception\destroy_failed;

class destroy extends action {

    public function run(destroys $oDestroys) {
        try {
            $oDestroys->run(request::all('args\0'));
            return [ 'message' => '菜单删除成功' ];
        } catch (destroy_failed $oE) {
            return response::apiError($oE->getMessage());
        } 
    }

}
