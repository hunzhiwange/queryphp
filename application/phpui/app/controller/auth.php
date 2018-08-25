<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace home\application\controller;

use queryyetsimple\auth\interfaces\connect as auth_connect;
use queryyetsimple\bootstrap\auth\login_register as login_register;
use queryyetsimple\mvc\controller;
use queryyetsimple\session;

class auth extends controller
{
    use login_register;
    protected $oAuth;
    protected $oUser;

    public function __construct(auth_connect $oAuth)
    {
        $this->oAuth = $oAuth;

        session::start();
    }

    /**
     * 默认方法.
     */
    public function index()
    {
        $this->assign('oUser', $this->getLogin());

        return $this->display();
    }
}
