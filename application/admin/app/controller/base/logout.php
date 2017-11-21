<?php

namespace admin\app\controller\base;

use queryyetsimple\mvc\action;
use queryyetsimple\bootstrap\auth\logout as auth_login_api;
use queryyetsimple\session;
use queryyetsimple\http\request;
use queryyetsimple\option;
use queryyetsimple\auth;

class logout extends action
{
    use auth_login_api;
    public function run(request $oRequest)
    {
        $strApiToken = $oRequest->header('authKey');
        auth::setTokenName($strApiToken);

        return $this->logout();
    }
}
