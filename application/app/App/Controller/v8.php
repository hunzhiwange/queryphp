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

namespace home\app\controller;

use queryyetsimple\mvc\controller;

/**
 * v8 控制器.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.01.10
 *
 * @version 1.0
 */
class v8 extends controller
{
    /**
     * vue 演示.
     */
    public function index()
    {
        $this->assign('msg', 'hello world');

        return $this->
        switchView(app('v8'))->

        display();
    }

    /**
     * art 演示.
     */
    public function art()
    {
        $this->assign('list', [
            '摄影',
            '电影',
            '民谣',
            '旅行',
            '吉他',
        ]);

        return $this->
        switchView(app('v8'))->

        display();
    }

    /**
     * require 演示.
     */
    public function requires()
    {
        return $this->
        switchView(app('v8'))->

        display();
    }
}
