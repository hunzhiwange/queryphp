<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\traits\dynamic;

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

use Closure;
use ReflectionFunction;
use Q\assert\assert;
use Q\exception\exceptions;
use Q\mvc\project;
use Q\option\option;

/**
 * 动态扩展复用
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.04
 * @version 1.0
 */
trait expansion {
    
    /**
     * 注入容器实例
     *
     * @var object
     */
    protected static $objExpansionInstance = null;
    
    /**
     * 注册的动态扩展
     *
     * @var array
     */
    protected static $arrExpansion = [ ];
    
    /**
     * 项目中的扩展参数
     *
     * @var array
     */
    protected $arrExpansionInstanceArgs = [ ];
    
    /**
     * 注册一个扩展
     *
     * @param string $strName            
     * @param callable $calExpansion            
     * @return void
     */
    public static function registerExpansion($strName, callable $calExpansion) {
        assert::string ( $strName );
        static::$arrExpansion [$strName] = $calExpansion;
    }
    
    /**
     * 判断一个扩展是否注册
     *
     * @param string $strName            
     * @return bool
     */
    public static function hasExpansion($strName) {
        assert::string ( $strName );
        return isset ( static::$arrExpansion [$strName] );
    }
    
    /**
     * 获取注册容器的实例
     *
     * @return mixed
     */
    public static function getExpansionInstance() {
        if (static::$objExpansionInstance) {
            return static::$objExpansionInstance;
        }
        if (! class_exists ( '\Q\mvc\project' ) || ! (static::$objExpansionInstance = project::bootstrap ()->make ( get_called_class () ))) {
            static::$objExpansionInstance = new self ();
        }
        if (method_exists ( static::$objExpansionInstance, 'initExpansionInstance_' )) {
            return static::$objExpansionInstance->initExpansionInstance_ ();
        } else {
            return static::$objExpansionInstance->initExpansionInstanceDefault_ ();
        }
    }
    
    /**
     * 初始化静态入口配置
     *
     * @return void
     */
    protected function initExpansionInstanceDefault_() {
        // 不存在初始化参数直接返回
        if (! $this->checkInitExpansionInstanceArgs_ ()) {
            return $this;
        }
        
        $this->mergeExpansionInstanceArgs_ ();
        
        $arrArgs = [ ];
        foreach ( $this->initExpansionInstanceArgs_ () as $sArgs ) {
            if (is_null ( $mixTemp = option::gets ( $sArgs ) ))
                continue;
            $arrArgs [$sArgs] = $mixTemp;
        }
        return $this->setExpansionInstanceArgs ( $arrArgs );
    }
    
    /**
     * 返回初始化参数
     *
     * @return array
     */
    protected function initExpansionInstanceArgs_() {
        if (! $this->checkInitExpansionInstanceArgs_ ()) {
            return [ ];
        }
        return array_keys ( $this->arrInitExpansionInstanceArgs );
    }
    
    /**
     * 初始化参数是否存在
     *
     * @return boolean
     */
    protected function checkInitExpansionInstanceArgs_() {
        return property_exists ( $this, 'arrInitExpansionInstanceArgs' );
    }
    
    /**
     * 设置配置
     *
     * @param array|string $mixArgsName            
     * @param string $strArgsValue            
     * @return void
     */
    public function setExpansionInstanceArgs($mixArgsName, $strArgsValue = null) {
        if (is_array ( $mixArgsName )) {
            $this->arrExpansionInstanceArgs = array_merge ( $this->arrExpansionInstanceArgs, $mixArgsName );
        } else {
            $this->arrExpansionInstanceArgs [$mixArgsName] = $strArgsValue;
        }
        return $this;
    }
    
    /**
     * 返回配置
     *
     * @param string $strArgsName            
     * @return mixed
     */
    protected function getExpansionInstanceArgs_($strArgsName) {
        return isset ( $this->arrExpansionInstanceArgs [$strArgsName] ) ? $this->arrExpansionInstanceArgs [$strArgsName] : null;
    }
    
    /**
     * 合并默认配置
     *
     * @return array
     */
    protected function mergeExpansionInstanceArgs_() {
        if (! $this->checkInitExpansionInstanceArgs_ ()) {
            return;
        }
        $this->arrExpansionInstanceArgs = array_merge ( $this->arrInitExpansionInstanceArgs, $this->arrExpansionInstanceArgs );
    }
    
    /**
     * 缺省静态方法
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return mixed
     */
    public static function __callStatic($sMethod, $arrArgs) {
        // 第一步：判断是否存在已经注册的命名
        if (static::hasExpansion ( $sMethod )) {
            if (static::$arrExpansion [$sMethod] instanceof Closure) {
                return call_user_func_array ( Closure::bind ( static::$arrExpansion [$sMethod], null, get_called_class () ), $arrArgs );
            } else {
                return call_user_func_array ( static::$arrExpansion [$sMethod], $arrArgs );
            }
        }
        
        // 第二步：尝试读取注入容器中的类，没有则自身创建为单一实例
        $objInstance = static::getExpansionInstance ();
        if (! $objInstance) {
            exceptions::runtimeException ();
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
            exceptions::badFunctionCallException ();
        }
        
        return call_user_func_array ( $sMethod, $arrArgs );
    }
    
    /**
     * 缺省方法
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return mixed
     */
    public function __call($sMethod, $arrArgs) {
        if (static::hasExpansion ( $sMethod )) {
            if (static::$arrExpansion [$sMethod] instanceof Closure) {
                $objReflection = new ReflectionFunction ( static::$arrExpansion [$sMethod] );
                return call_user_func_array ( Closure::bind ( static::$arrExpansion [$sMethod], $objReflection->getClosureThis () ? $this : NULL, get_class ( $this ) ), $arrArgs );
            } else {
                return call_user_func_array ( static::$arrExpansion [$sMethod], $arrArgs );
            }
        }
        
        exceptions::badMethodCallException ();
    }
}
