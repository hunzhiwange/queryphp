<?php
// ©2017 http://your.domain.com All rights reserved.
use queryyetsimple\bootstrap\testing\testcase;

/**
 * 继承框架基础示例
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class ExampleTest extends testcase {
    
    /**
     * 基本测试
     *
     * @return void
     */
    public function testBase() {
        $this->assertEquals ( 'QueryPHP', 'QueryPHP' );
    }
}
