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

namespace Common\Domain\Event;

/**
 * test 事件.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.01.29
 *
 * @version 1.0
 */
class Test extends Event
{
    /**
     * 博客内容.
     *
     * @var string
     */
    protected $blog;

    /**
     * 构造函数
     * 支持依赖注入.
     *
     * @param string $blog
     */
    public function __construct($blog)
    {
        $this->blog = $blog;
    }

    /**
     * 返回博客内容.
     *
     * @return string
     */
    public function blog()
    {
        return $this->blog;
    }
}
