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
        'Common\Domain\Event\Test' => [
            // 优先级支持写法，数字越小越早执行，默认为 500
            // 'Common\Domain\Listener\Test' => 6
            'Common\Domain\Listener\Test',
            'Common\Domain\Listener\Test2' => 5,
            'Common\Domain\Listener\Test3' => 2
        ],
        
        'Common\Domain\Event\Wildcards*' => [
            'Common\Domain\Listener\Test'
        ],

        'Common\Domain\Event\WildcardsTest' => [
            'Common\Domain\Listener\Test2'
        ]
    ];
}
