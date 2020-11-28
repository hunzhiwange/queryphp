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

namespace Common\Domain\Event;

class Demo extends Event
{
    /**
     * 博客内容.
     */
    private string $blog;

    /**
     * 构造函数.
     *
     * - 支持依赖注入.
     */
    public function __construct(string $blog)
    {
        $this->blog = $blog;
    }

    /**
     * 返回博客内容.
     */
    public function blog(): string
    {
        return $this->blog;
    }
}
