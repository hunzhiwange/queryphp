<?php

namespace admin\app\controller\base;

use queryyetsimple\mvc\action;
use admin\is\verify\image;

class getVerify extends action {

    public function run(image $oImage) {
        return $oImage->run();
    }

}