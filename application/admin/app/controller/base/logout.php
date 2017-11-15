<?php

namespace admin\app\controller\base;

use queryyetsimple\mvc\action;
use queryyetsimple\bootstrap\auth\login as auth_login_api;
use queryyetsimple\session;
use queryyetsimple\http\request;
use queryyetsimple\option;
use queryyetsimple\auth;

class logout extends action
{
    use auth_login_api;

    public function run(request $oRequest)
    {
        $oRequest->setPost(option::get('var_ajax'), true);
        $strApiToken = $oRequest->header('authKey');
        auth::setTokenName($strApiToken);

        return $this->logout();
    }
}
