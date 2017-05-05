<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\exception;

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
     * PHP 系统异常
     *
     * @var array
     */
    private static $arrPHPType = [
            // 顶级异常
            'Exception' => 'Exception happen.',
            
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
     * 抛出异常
     *
     * @param string $sMsg            
     * @param string $sType            
     * @param number $nCode            
     * @return void
     */
    public static function throws($sMsg, $sType = 'Exception', $nCode = 0) {
        throw new $sType ( $sMsg, $nCode );
    }
    
    /**
     * 拦截异常静态方法
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return boolean
     */
    public static function __callStatic($sMethod, $arrArgs) {
        $sMethod = ucfirst ( $sMethod );
        if (! array_key_exists ( $sMethod, static::$arrPHPType )) {
            $sMethod = 'Exception';
        }
        
        if (! isset ( $arrArgs [0] )) {
            $arrArgs [0] = static::$arrPHPType [$sMethod];
        }
        if (! isset ( $arrArgs [1] )) {
            $arrArgs [1] = 0;
        }
        
        throw new $sMethod ( $arrArgs [0], ( int ) $arrArgs [1] );
    }
}
