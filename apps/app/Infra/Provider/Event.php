<?php

declare(strict_types=1);

namespace App\Infra\Provider;

use App\Domain\Listener\Test;
use App\Domain\Listener\Test2;
use App\Domain\Listener\Test3;
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
        'App\\Domain\\Event\\Test' => [
            // 优先级支持写法，数字越小越早执行，默认为 500
            // Test::class => 6
            Test::class,
            Test2::class => 5,
            Test3::class => 2,
        ],

        'App\\Domain\\Event\\Wildcards*' => [
            Test::class,
        ],

        'App\\Domain\\Event\\WildcardsTest' => [
            Test2::class,
        ],
    ];
}
