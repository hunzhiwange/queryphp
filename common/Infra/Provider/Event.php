<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace Common\Infra\Provider;

use Leevel\Event\EventProvider;

/**
 * 事件服务提供者
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2018.01.29
 * @version 1.0
 */
class Event extends EventProvider
{
    protected $listeners = [
        // 'common\domain\event\test' => [
        //     // 优先级支持写法，数字越小越早执行，默认为 500
        //     // 'common\domain\listener\test' => 6
        //     'common\domain\listener\test',
        //     'common\domain\listener\test2' => 5,
        //     'common\domain\listener\test3' => 2
        // ],
        
        // 'common\domain\event\Wildcards*' => [
        //     'common\domain\listener\test'
        // ],

        // 'common\domain\event\WildcardsTest' => [
        //     'common\domain\listener\test2'
        // ]
    ];
}
