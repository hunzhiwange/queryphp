<?php

namespace admin\application\controller\base;

use queryyetsimple\mvc\action;
use queryyetsimple\bootstrap\auth\login_api as auth_login_api;
use queryyetsimple\session;

class logout extends action {

    use auth_login_api;

    public function run() {
      session::start();
        $this->logout();
        return ['退出成功'];
    }


}