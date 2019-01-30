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

use Leevel\Event\EventProvider;

/**
 * 事件服务提供者.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.01.29
 *
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
            'Common\Domain\Listener\Test3' => 2,
        ],

        'Common\Domain\Event\Wildcards*' => [
            'Common\Domain\Listener\Test',
        ],

        'Common\Domain\Event\WildcardsTest' => [
            'Common\Domain\Listener\Test2',
        ],
    ];
}
