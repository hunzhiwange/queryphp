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

namespace Common\Domain\Listener;

use Leevel\Event\Observer;

/**
 * 监听器抽象.
 *
 * - 可以继承至 \Leevel\Event\Observer，因为系统基于 Spl 观察者模式实现的事件.
 * - 也可以是闭包，也可以不继承，但是最终都转化为 \Leevel\Event\Observer.
 */
abstract class Listener extends Observer
{
}
