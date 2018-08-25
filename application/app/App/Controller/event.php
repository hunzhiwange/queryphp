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

use Queryyetsimple\Event;
use Queryyetsimple\Mvc\Controller;

/**
 * event 控制器.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
class event extends Controller
{
    /**
     * 默认方法.
     */
    public function index()
    {
        $event = app('event');
        $event->run('common\domain\event\WildcardsTest', 1, 2, 3, 4);
    }

    /**
     * 门面方法.
     */
    public function event()
    {
        self::run('common\domain\event\test', 1, 2, 3, 4);
    }
}
