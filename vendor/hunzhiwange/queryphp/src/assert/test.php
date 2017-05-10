<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\assert;

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

use Q\exception\exceptions;
use Q\traits\dynamic\expansion as dynamic_expansion;

/**
 * 数据类型检查
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.05
 * @version 1.0
 */
class test {
    
    use dynamic_expansion;
    
    /**
     * 验证 PHP 各种变量类型
     *
     * @param 待验证的变量 $mixVar            
     * @param string $sType
     *            变量类型
     * @return boolean
     */
    public static function varType($mixVar, $sType) {
        $sType = trim ( $sType ); // 整理参数，以支持 array:ini 格式
        $sType = explode ( ':', $sType );
        $sType [0] = strtolower ( $sType [0] );
        
        switch ($sType [0]) {
            case 'string' : // 字符串
                return is_string ( $mixVar );
            case 'integer' : // 整数
            case 'int' :
                return is_int ( $mixVar );
            case 'float' : // 浮点
                return is_float ( $mixVar );
            case 'boolean' : // 布尔
            case 'bool' :
                return is_bool ( $mixVar );
            case 'num' : // 数字
            case 'numeric' :
                return is_numeric ( $mixVar );
            case 'base' : // 标量（所有基础类型）
            case 'scalar' :
                return is_scalar ( $mixVar );
            case 'handle' : // 外部资源
            case 'resource' :
                return is_resource ( $mixVar );
            case 'array' :
                { // 数组
                    if (! empty ( $sType [1] )) {
                        $sType [1] = explode ( ',', $sType [1] );
                        return static::checkArray ( $mixVar, $sType [1] );
                    } else {
                        return is_array ( $mixVar );
                    }
                }
            case 'object' : // 对象
                return is_object ( $mixVar );
            case 'null' : // 空
                return ($mixVar === null);
            case 'callback' : // 回调函数
                return is_callable ( $mixVar, false );
            default : // 类
                return static::isKindOf ( $mixVar, implode ( ':', $sType ) );
        }
    }
    
    /**
     * 验证是否为同一回调
     *
     * @param callback $calA            
     * @param callback $calkB            
     * @return boolean
     */
    public static function isSameCallback($calA, $calB) {
        if (! is_callable ( $calA ) || is_callable ( $calB )) {
            return false;
        }
        
        if (is_array ( $calA )) {
            if (is_array ( $calB )) {
                return ($calA [0] === $calB [0]) and (strtolower ( $calA [1] ) === strtolower ( $calB [1] ));
            } else {
                return false;
            }
        } else {
            return strtolower ( $calA ) === strtolower ( $calB );
        }
    }
    
    /**
     * 验证参数是否为指定的类型集合
     *
     * @param mixed $mixVar            
     * @param mixed $mixTypes            
     * @return boolean
     */
    public static function isThese($mixVar, $mixTypes) {
        if (! static::varType ( $mixTypes, 'string' ) && ! static::checkArray ( $mixTypes, [ 
                'string' 
        ] )) {
            \Exceptions::throws ( __ ( '正确格式:参数必须为 string 或 各项元素为 string 的数组' ) );
        }
        
        if (is_string ( $mixTypes )) {
            $mixTypes = [ 
                    $mixTypes 
            ];
        }
        
        foreach ( $mixTypes as $sType ) { // 类型检查
            if (static::varType ( $mixVar, $sType )) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * 检查一个对象实例或者类名是否继承至接口或者类
     *
     * @param mixed $mixSubClass            
     * @param string $sBaseClass            
     * @return boolean
     */
    public static function isKindOf($mixSubClass, $sBaseClass) {
        if (interface_exists ( $sBaseClass )) { // 接口
            return static::isImplementedTo ( $mixSubClass, $sBaseClass );
        } else { // 类
            if (is_object ( $mixSubClass )) { // 统一类名,如果不是，返回false
                $mixSubClass = get_class ( $mixSubClass );
            } elseif (! is_string ( $mixSubClass )) {
                return false;
            }
            
            if ($mixSubClass == $sBaseClass) { // 子类名 即为父类名
                return true;
            }
            
            $sParClass = get_parent_class ( $mixSubClass ); // 递归检查
            if (! $sParClass) {
                return false;
            }
            
            return static::isKindOf ( $sParClass, $sBaseClass );
        }
    }
    
    /**
     * 检查对象实例或者类名 是否继承至接口
     *
     * @param mixed $mixClass            
     * @param string $sInterface            
     * @param string $bStrictly            
     * @return boolean
     */
    public static function isImplementedTo($mixClass, $sInterface, $bStrictly = false) {
        if (is_object ( $mixClass )) { // 尝试获取类名，否则返回false
            $mixClass = get_class ( $mixClass );
            if (! is_string ( $mixClass )) { // 类型检查
                return false;
            }
        } elseif (! is_string ( $Class )) {
            return false;
        }
        
        if (! class_exists ( $mixClass ) || ! interface_exists ( $sInterface )) { // 检查类和接口是否都有效
            return false;
        }
        
        // 建立反射
        $oReflectionClass = new ReflectionClass ( $sClassName );
        $arrInterfaceRefs = $oReflectionClass->getInterfaces ();
        foreach ( $arrInterfaceRefs as $oInterfaceRef ) {
            if ($oInterfaceRef->getName () != $sInterface) {
                continue;
            }
            
            if (! $bStrictly) { // 找到 匹配的 接口
                return true;
            }
            
            // 依次检查接口中的每个方法是否实现
            $arrInterfaceFuncs = get_class_methods ( $sInterface );
            foreach ( $arrInterfaceFuncs as $sFuncName ) {
                $sReflectionMethod = $oReflectionClass->getMethod ( $sFuncName );
                if ($sReflectionMethod->isAbstract ()) { // 发现尚为抽象的方法
                    return false;
                }
            }
            
            return true;
        }
        
        // 递归检查父类
        if (($sParName = get_parent_class ( $sClassName )) !== false) {
            return static::isImplementedTo ( $sParName, $sInterface, $bStrictly );
        } else {
            return false;
        }
    }
    
    /**
     * 验证数组中的每一项格式化是否正确
     *
     * @param array $arrArray            
     * @param array $arrTypes            
     * @return boolean
     */
    public static function checkArray($arrArray, array $arrTypes) {
        if (! is_array ( $arrArray )) { // 不是数组直接返回
            return false;
        }
        
        // 判断数组内部每一个值是否为给定的类型
        foreach ( $arrArray as &$mixValue ) {
            $bRet = false;
            foreach ( $arrTypes as $mixType ) {
                if (static::varType ( $mixValue, $mixType )) {
                    $bRet = true;
                    break;
                }
            }
            
            if (! $bRet) {
                return false;
            }
        }
    
        return true;
    }
    
}
