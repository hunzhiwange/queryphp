<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\exception;

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

use Exception;
use LogicException;
use BadFunctionCallException;
use BadMethodCallException;
use DomainException;
use InvalidArgumentException;
use LengthException;
use OutOfRangeException;
use RuntimeException;
use OutOfBoundsException;
use OverflowException;
use RangeException;
use UnderflowException;
use UnexpectedValueException;

/**
 * 异常处理
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.01.09
 * @version 1.0
 */
class exceptions {
    
    /**
     * 系统异常
     *
     * @var array
     */
    protected static $arrType = [

            // 自定义异常
            'ThrowException' => 'An exception happened.',


            // 顶级异常
            'Exception' => 'Exception happened.',
            
            // 表示程序逻辑中的错误的异常
            'LogicException' => 'Program logic.',
            
            // 如果回调指向未定义函数或某些参数丢失，则引发异常
            // 通常与 is_callable 结合判断
            'BadFunctionCallException' => 'Function is not callable.',
            
            // 当一个回调方法是一个未定义的方法或缺失一些参数时会抛出该异常
            // 通常在 __call 魔术方法中调用
            'BadMethodCallException' => 'Method does not exist.',
            
            // 如果值不遵守定义的有效数据域，则引发异常
            'DomainException' => 'Unknown domain.',
            
            // 如果参数不为预期类型，则引发异常
            'InvalidArgumentException' => 'Invalid argument.',
            
            // 如果长度无效，则引发异常
            'LengthException' => 'Length is invalid.',
            
            // 超出范围的严重错误
            // 例如读取一年的 15 月份
            'OutOfRangeException' => 'Data out Of range.',
            
            // 如果在运行时只能找到错误，则引发异常
            'RuntimeException' => 'Runtime error.',
            
            // 如果值不是有效键，则引发异常
            // 通常在 array_key_exists 不存在中调用
            'OutOfBoundsException' => 'Data out of bounds.',
            
            // 溢出异常
            'OverflowException' => 'Data is Overflow.',
            
            // 指示范围错误的异常
            'RangeException' => 'Data is not in range.',
            
            // 未定义的操作异常
            // 比如 unset 一个不存在数组元素
            'UnderflowException' => 'Data is underflow.',
            
            // 与期望不符合的抛出异常
            // 例如定义的 const 中的比对参数
            'UnexpectedValueException' => 'Unexpected value.' 
    ];

    /**
     * 抛出自定义异常
     *
     * @param string $sType  
     * @param string $sMsg              
     * @param number $nCode            
     * @return void
     */
    public static function throwException($sType = 'Exception', $sMsg=null, $nCode = 0) {
        throw new $sType ( static::defaultMessage_ ( 'ThrowException', $sMsg ), $nCode );
    }
    
    /**
     * Exception
     * 顶级异常 Exception happened.
     *
     * @param string $sMsg            
     * @param number $nCode            
     * @return void
     */
    public static function exception($sMsg = null, $nCode = 0) {
        throw new Exception ( static::defaultMessage_ ( 'UnexpectedValueException', $sMsg ), $nCode );
    }
    
    /**
     * LogicException
     * 表示程序逻辑中的错误的异常 Program logic.
     *
     * @param string $sMsg            
     * @param number $nCode            
     * @return void
     */
    public static function logicException($sMsg = null, $nCode = 0) {
        throw new LogicException ( static::defaultMessage_ ( 'UnexpectedValueException', $sMsg ), $nCode );
    }
    
    /**
     * BadFunctionCallException
     * 如果回调指向未定义函数或某些参数丢失，则引发异常.通常与 is_callable 结合判断.
     * Function is not callable.
     *
     * @param string $sMsg            
     * @param number $nCode            
     * @return void
     */
    public static function badFunctionCallException($sMsg = null, $nCode = 0) {
        throw new BadFunctionCallException ( static::defaultMessage_ ( 'UnexpectedValueException', $sMsg ), $nCode );
    }
    
    /**
     * BadMethodCallException
     * 当一个回调方法是一个未定义的方法或缺失一些参数时会抛出该异常.通常在 __call 魔术方法中调用.
     * Method does not exist.
     *
     * @param string $sMsg            
     * @param number $nCode            
     * @return void
     */
    public static function badMethodCallException($sMsg = null, $nCode = 0) {
        throw new BadMethodCallException ( static::defaultMessage_ ( 'UnexpectedValueException', $sMsg ), $nCode );
    }
    
    /**
     * DomainException
     * 如果值不遵守定义的有效数据域，则引发异常.Unknown domain.
     *
     * @param string $sMsg            
     * @param number $nCode            
     * @return void
     */
    public static function domainException($sMsg = null, $nCode = 0) {
        throw new DomainException ( static::defaultMessage_ ( 'UnexpectedValueException', $sMsg ), $nCode );
    }
    
    /**
     * InvalidArgumentException
     * 如果参数不为预期类型，则引发异常.Invalid argument.
     *
     * @param string $sMsg            
     * @param number $nCode            
     * @return void
     */
    public static function invalidArgumentException($sMsg = null, $nCode = 0) {
        throw new InvalidArgumentException ( static::defaultMessage_ ( 'UnexpectedValueException', $sMsg ), $nCode );
    }
    
    /**
     * LengthException
     * 如果长度无效，则引发异常.Length is invalid.
     *
     * @param string $sMsg            
     * @param number $nCode            
     * @return void
     */
    public static function lengthException($sMsg = null, $nCode = 0) {
        throw new LengthException ( static::defaultMessage_ ( 'UnexpectedValueException', $sMsg ), $nCode );
    }
    
    /**
     * OutOfRangeException
     * 超出范围的严重错误.例如读取一年的 15 月份.Data out Of range.
     *
     * @param string $sMsg            
     * @param number $nCode            
     * @return void
     */
    public static function outOfRangeException($sMsg = null, $nCode = 0) {
        throw new OutOfRangeException ( static::defaultMessage_ ( 'UnexpectedValueException', $sMsg ), $nCode );
    }
    
    /**
     * runtimeException
     * 如果在运行时只能找到错误，则引发异常.Runtime error.
     *
     * @param string $sMsg            
     * @param number $nCode            
     * @return void
     */
    public static function runtimeException($sMsg = null, $nCode = 0) {
        throw new RuntimeException ( static::defaultMessage_ ( 'UnexpectedValueException', $sMsg ), $nCode );
    }
    
    /**
     * OutOfBoundsException
     * 如果值不是有效键，则引发异常.通常在 array_key_exists 不存在中调用.
     * Data out of bounds.
     *
     * @param string $sMsg            
     * @param number $nCode            
     * @return void
     */
    public static function outOfBoundsException($sMsg = null, $nCode = 0) {
        throw new OutOfBoundsException ( static::defaultMessage_ ( 'UnexpectedValueException', $sMsg ), $nCode );
    }
    
    /**
     * OverflowException
     * 溢出异常.Data is Overflow.
     *
     * @param string $sMsg            
     * @param number $nCode            
     * @return void
     */
    public static function overflowException($sMsg = null, $nCode = 0) {
        throw new OverflowException ( static::defaultMessage_ ( 'UnexpectedValueException', $sMsg ), $nCode );
    }
    
    /**
     * RangeException
     * 指示范围错误的异常.Data is not in range.
     *
     * @param string $sMsg            
     * @param number $nCode            
     * @return void
     */
    public static function rangeException($sMsg = null, $nCode = 0) {
        throw new RangeException ( static::defaultMessage_ ( 'UnexpectedValueException', $sMsg ), $nCode );
    }
    
    /**
     * UnderflowException
     * 未定义的操作异常.比如 unset 一个不存在数组元素.Data is underflow.
     *
     * @param string $sMsg            
     * @param number $nCode            
     * @return void
     */
    public static function underflowException($sMsg = null, $nCode = 0) {
        throw new UnderflowException ( static::defaultMessage_ ( 'UnexpectedValueException', $sMsg ), $nCode );
    }
    
    /**
     * UnexpectedValueException
     * 与期望不符合的抛出异常.例如定义的 const 中的比对参数.Unexpected value.
     *
     * @param string $sMsg            
     * @param number $nCode            
     * @return void
     */
    public static function unexpectedValueException($sMsg = null, $nCode = 0) {
        throw new UnexpectedValueException ( static::defaultMessage_ ( 'UnexpectedValueException', $sMsg ), $nCode );
    }
    
    /**
     * 默认异常消息
     *
     * @param string $sType            
     * @param string $sMsg            
     *
     * @return void
     */
    protected static function defaultMessage_($sType, $sMsg = null) {
        return $sMsg ?  : static::$arrType [$sType];
    }
    
}
