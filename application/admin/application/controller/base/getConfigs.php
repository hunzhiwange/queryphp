<?php

namespace admin\application\controller\base;

use queryyetsimple\mvc\action;
use admin\domain\service\common_option\get;

class getConfigs extends action {

    public function run(get $oGet) {
        return $oGet->run();
    }

}