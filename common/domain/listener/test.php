<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\domain\listener;

/**
 * test 监听器
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2018.01.29
 * @version 1.0
 */
class test extends abstracts
{

    /**
     * 构造函数
     * 支持依赖注入
     * 
     * @return void
     */
    public function __construct () {
    }

    /**
     * 监听器响应
     * 
     * @return void
     */
    public function run()
    {
        $args = func_get_args();

        $event = array_shift($args);

        print_r($args);
    }
}
