<?php

namespace admin\app\controller\menus;

use queryyetsimple\request;
use queryyetsimple\response;
use queryyetsimple\mvc\action;
use admin\app\service\menus\create as service;
use admin\domain\repository\menus\exception\create_failed;

class create extends action {

    public function run(service $oService) {
        try {
            return $oService->run( request::all('pid') );
        } catch (index_failed $oE) {
            return response::apiError($oE->getMessage());
        }
    }

}
