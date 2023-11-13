<?php

declare(strict_types=1);

namespace App\Infra\Listener;

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
