<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\traits;

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

/**
 * 对象参数复用
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.04
 * @version 1.0
 */
trait static_entrance {
    
    /**
     * 静态入口实例
     *
     * @var object
     */
    protected static $objStaticEntranceInstance = null;
    
    /**
     * 获取注册的实例
     *
     * @return mixed
     */
    public static function getStaticEntrance() {
        if (static::$objStaticEntranceInstance) {
            return static::$objStaticEntranceInstance;
        }
        return static::$objStaticEntranceInstance = \Q\mvc\project::bootstrap ()->make ( get_called_class () )->initStaticEntrance_ ();
    }
    
    /**
     * 初始化静态入口配置
     *
     * @return void
     */
    protected function initStaticEntrance_() {
        return $this;
    }
    
    /**
     * 返回初始化参数
     *
     * @return array
     */
    protected function getStaticEntranceType_() {
        return $this->arrStaticEntranceType;
    }
    
    /**
     * 拦截匿名注册控制器方法
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return mixed
     */
    public static function __callStatic($sMethod, $arrArgs) {
        $objInstance = static::getStaticEntrance ();
        if (! $objInstance) {
            exception::runtime ( 'A static entrance has not been set.' );
        }
        
        // 移除最后一位方法名字去访问内容，于是可以在方法后面加入 s 或者 _ 来访问类的方法
        // 非 s 和 _ 结尾的由程序通过 __call 方法实现
        if (in_array ( substr ( $sMethod, - 1 ), [ 
                's',
                '_' 
        ] )) {
            $sMethod = substr ( $sMethod, 0, - 1 );
        }
        $sMethod = [ 
                $objInstance,
                $sMethod 
        ];
        if (! is_callable ( $sMethod )) {
            exception::badFunctionCall ();
        }
        
        return call_user_func_array ( $sMethod, $arrArgs );
    }
}
