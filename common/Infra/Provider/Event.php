<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Infra\Provider;

use Common\Domain\Listener\Test;
use Common\Domain\Listener\Test2;
use Common\Domain\Listener\Test3;
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
        'Common\\Domain\\Event\\Test' => [
            // 优先级支持写法，数字越小越早执行，默认为 500
            // Test::class => 6
            Test::class,
            Test2::class => 5,
            Test3::class => 2,
        ],

        'Common\\Domain\\Event\\Wildcards*' => [
            Test::class,
        ],

        'Common\\Domain\\Event\\WildcardsTest' => [
            Test2::class,
        ],
    ];
}
