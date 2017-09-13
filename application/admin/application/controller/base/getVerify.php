<?php

namespace admin\application\controller\base;

use queryyetsimple\mvc\action;
use admin\infrastructure\verify\image;

class getVerify extends action {

    public function run(image $oImage) {
        return $oImage->run();
    }

}