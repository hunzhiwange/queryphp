<?php
// ©2017 http://your.domain.com All rights reserved.
use PHPUnit\Framework\TestCase;

/**
 * 原生 PHPUnit 示例
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class PHPUnitTest extends TestCase
{

    /**
     * 基本测试
     *
     * @return void
     */
    public function testBase()
    {
        $this->assertEquals('QueryPHP', 'QueryPHP');
    }
}
