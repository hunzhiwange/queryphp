<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\domain\listener;

use Queryyetsimple\Event\Observer;

/**
 * 监听器抽象
 * 必须继承至 \Queryyetsimple\Event\Observer，因为系统基于 Spl 观察者模式实现的事件
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2018.01.29
 * @version 1.0
 */
abstract class abstracts extends Observer
{
}
