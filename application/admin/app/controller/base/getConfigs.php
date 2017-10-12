<?php

namespace admin\app\controller\base;

use queryyetsimple\response;
use queryyetsimple\mvc\action;
use admin\app\service\base\getConfigs as service;
use admin\domain\repository\base\exception\getConfigs_failed;

class getConfigs extends action {

    public function run(service $oService) {
        try {
            return $oService->run();
        } catch (getConfigs_failed $oE) {
            return response::apiError($oE->getMessage());
        }
    }

}
