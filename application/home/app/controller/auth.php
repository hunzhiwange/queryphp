<?php

namespace home\application\controller;

use Exception;
use queryyetsimple\mvc\controller;
use queryyetsimple\request;
use queryyetsimple\response;
use queryyetsimple\auth\interfaces\connect as auth_connect;
use home\domain\model\common_user;
use queryyetsimple\session;
use queryyetsimple\bootstrap\auth\login_register as login_register;

class auth extends controller {

    use login_register;

    protected $oAuth;
    protected $oUser;

    public function __construct(auth_connect $oAuth){
        $this->oAuth = $oAuth;

        session::start();
    }

    /**
     * 默认方法
     *
     * @return void
     */
    public function index() {
        $this->assign('oUser',$this->getLogin());
        return $this->display ();
    }

}
