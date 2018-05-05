<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace home\app\controller;

use Queryyetsimple\Event;
use Queryyetsimple\Mvc\Controller;

/**
 * event 控制器
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class event extends Controller
{

    /**
     * 默认方法
     *
     * @return void
     */
    public function index()
    {
        $event = app('event');
        $event->run('common\domain\event\WildcardsTest', 1, 2, 3, 4);
    }

    /**
     * 门面方法
     *
     * @return void
     */
    public function event(){
        Event::run('common\domain\event\test', 1, 2, 3, 4);
    }
}
