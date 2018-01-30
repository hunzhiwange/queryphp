<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\domain\event;

/**
 * test 事件
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2018.01.29
 * @version 1.0
 */
class test extends abstracts
{

    /**
     * 博客内容
     * 
     * @var string
     */
    protected $blog;

    /**
     * 构造函数
     * 支持依赖注入
     * 
     * @param string $blog
     * @return void
     */
    public function __construct ($blog) {
        $this->blog = $blog;
    }

    /**
     * 返回博客内容
     * 
     * @return string
     */
    public function blog () {
        return $this->blog;
    }
}
