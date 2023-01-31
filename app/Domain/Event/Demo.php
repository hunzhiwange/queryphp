<?php

declare(strict_types=1);

namespace App\Domain\Event;

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
