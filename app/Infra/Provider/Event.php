<?php

declare(strict_types=1);

namespace App\Infra\Provider;

use App\Domain\Event\WildcardsDemo;
use App\Domain\Listener\Demo;
use App\Domain\Listener\Demo2;
use App\Domain\Listener\Demo3;
use Leevel\Event\EventProvider;

/**
 * 事件服务提供者.
 */
class Event extends EventProvider
{
    /**
     * 事件监听器.
     */
    protected array $listeners = [
        \App\Domain\Event\Demo::class => [
            // 优先级支持写法，数字越小越早执行，默认为 500
            // Demo::class => 6
            Demo::class,
            Demo2::class => 5,
            Demo3::class => 2,
        ],

        'App\\Domain\\Event\\Wildcards*' => [
            Demo::class,
        ],

        WildcardsDemo::class => [
            Demo2::class,
        ],
    ];
}
