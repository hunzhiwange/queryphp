<?php

namespace admin\app\controller\menus;

use queryyetsimple\request;
use queryyetsimple\response;
use queryyetsimple\mvc\action;
use admin\domain\service\admin_menu\update as updates;
use admin\domain\service\admin_menu\exception\update_failed;

class update extends action {

    public function run(updates $oUpdates) {
        try {
            $oUpdates->run(request::alls(['id|intval','menu|trim','module|trim','pid','sort|intval','title|trim','url|trim']));
            return [ 'message' => '菜单更新成功' ];
        } catch (update_failed $oE) {
            return response::apiError($oE->getMessage());
        } 
    }

}
