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

namespace Common\Domain\Listener;

use Leevel\Event\Observer;

/**
 * 监听器抽象
 * 可以继承至 \Leevel\Event\Observer，因为系统基于 Spl 观察者模式实现的事件.
 * 也可以是闭包，也可以不继承，但是最终都转化为 \Leevel\Event\Observer.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.01.29
 *
 * @version 1.0
 */
abstract class Listener extends Observer
{
}
