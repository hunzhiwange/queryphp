<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace tests\option;

<<<queryphp
##########################################################
#   ____                          ______  _   _ ______   #
#  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
# |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
#  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
#       \__   | \___ |_|    \__  || |    | | | || |      #
#     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
#                          |___ /  Since 2010.10.03      #
##########################################################
queryphp;

use queryyetsimple\option\option;
use tests\testcase;

/**
 * option 组件测试
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.09
 * @version 1.0
 */
class Option_test extends testcase {
    
    /**
     * 测试配置
     *
     * @var array
     */
    private static $arrTest = [ 
            'hello' => 'world',
            'router\name' => '小牛仔',
            'test\child' => [ 
                    'sub1' => 'hello',
                    'sub2' => 'world',
                    'sub3' => '新式软件',
                    'goods' => [ 
                            'world' => 'new' 
                    ] 
            ] 
    ];
    
    /**
     * 初始化
     *
     * @return void
     */
    protected function setUp() {
        option::resets ();
        option::sets ( self::$arrTest );
    }
    
    /**
     * 读取生成的命名空间配置结构
     *
     * @return void
     */
    public function testGetsAll() {
        $this->assertTrue ( option::gets ( true ) === [ 
                'app' => [ 
                        'hello' => 'world' 
                ],
                'router' => [ 
                        'name' => '小牛仔' 
                ],
                'test' => [ 
                        'child' => [ 
                                'sub1' => 'hello',
                                'sub2' => 'world',
                                'sub3' => '新式软件',
                                'goods' => [ 
                                        'world' => 'new' 
                                ] 
                        ] 
                ] 
        ] );
    }
    
    /**
     * 读取生成的命名空间配置结构
     *
     * @return void
     */
    public function testGetsOneNamespace() {
        $this->assertTrue ( option::gets ( 'router\\' ) === [ 
                'name' => '小牛仔' 
        ] );
    }
    
    /**
     * 获取信息
     *
     * @return void
     */
    public function testGets() {
        $this->assertEquals ( '小牛仔', option::gets ( 'router\name' ) );
        $this->assertEquals ( 'new', option::gets ( 'test\child.goods.world' ) );
        $this->assertEquals ( 'default value', option::gets ( 'not_found', 'default value' ) );
    }
    
    /**
     * 设置信息
     *
     * @return void
     */
    public function testSets() {
        option::sets ( 'hello', '技术成就未来' );
        $this->assertEquals ( '技术成就未来', option::gets ( 'hello' ) );
        option::sets ( 'router\child.sub2', '卧槽' );
        $this->assertEquals ( '卧槽', option::gets ( 'router\child.sub2' ) );
    }
}
