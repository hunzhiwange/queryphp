<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\is\cache;

/**
 * 测试缓存
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.20
 * @version 1.0
 */
class test
{
    
    /**
     * 构造函数
     *
     * @return  void
     */
    public function __construct()
    {
    }
    
    /**
     * 响应缓存
     *
     * @return array
     */
    public function handle()
    {
        return [
            'hello', 
            'world'
        ];
    }
}
