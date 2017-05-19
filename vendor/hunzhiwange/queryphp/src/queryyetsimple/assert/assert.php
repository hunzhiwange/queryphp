<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\assert;

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

use queryyetsimple\exception\exceptions;
use queryyetsimple\traits\dynamic\expansion as dynamic_expansion;

/**
 * 断言类
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.05
 * @version 1.0
 */
class assert {
    
    use dynamic_expansion;
    
    /**
     * 是否开启断言
     *
     * @var boolean
     */
    private static $booOpen = true;
    
    /**
     * 默认断言消息
     *
     * @var array
     */
    private static $arrMessage = [ 
            'trueExpression' => 'Make sure the incoming expression is true.',
            'notTrueExpression' => 'Make sure the incoming expression is false.',
            'true' => 'Make sure that the incoming variable must now be fully equal to true.',
            'notTrue' => 'Make sure that the incoming variable must now be fully equal to false.',
            'null' => 'Make sure that incoming variables must be null.',
            'notNull' => 'Make sure that incoming variables must be not null.',
            'zero' => 'Make sure that incoming variables must be zero.',
            'notZero' => 'Make sure that incoming variables must be not zero.',
            'stringZero' => 'Make sure that incoming variables must be string zero.',
            'notstringZero' => 'Make sure that incoming variables must be not string zero.',
            'strictZero' => 'Make sure that incoming variables must be strict zero.',
            'notStrictZero' => 'Make sure that incoming variables must be not strict zero.',
            'stringEmpty' => 'Make sure that incoming variables must be string empty.',
            'notStringEmpty' => 'Make sure that incoming variables must be not string empty.',
            'integer' => 'Make sure that incoming variables must be a integer.',
            'notInteger' => 'Make sure that incoming variables must be not a integer.',
            'float' => 'Make sure that incoming variables must be a float.',
            'notFloat' => 'Make sure that incoming variables must be not a float.',
            'numeric' => 'Make sure that incoming variables must be a number (including integer and floating point).',
            'notNumeric' => 'Make sure that incoming variables must be not a number (including integer and floating point).',
            'string' => 'Make sure that incoming variables must be a string.',
            'notString' => 'Make sure that incoming variables must be not a string.',
            'scalar' => 'Make sure that incoming variables must be a scalar.',
            'notScalar' => 'Make sure that incoming variables must be not a scalar.',
            'resource' => 'Make sure that incoming variables must be a resource.',
            'notResource' => 'Make sure that incoming variables must be not a resource.',
            'object' => 'Make sure that incoming variables must be a object.',
            'notObject' => 'Make sure that incoming variables must be not a object.',
            'callback' => 'Make sure that incoming variables must be a callback.',
            'notCallback' => 'Make sure that incoming variables must be not a callback.',
            'boolean' => 'Make sure that incoming variables must be a boolean.',
            'notBoolean' => 'Make sure that incoming variables must be not a boolean.',
            'isArray' => 'Make sure that incoming variables must be a array.',
            'notIsArray' => 'Make sure that incoming variables must be not a array.',
            'path' => 'Make sure path variables is valid.',
            'notPath' => 'Make sure path variables is not valid.',
            'file' => 'Make sure the path variables exists and is a file (not a directory).',
            'notFile' => 'Make sure the path variables exists and is a not file (not a directory).',
            'dir' => 'Make sure the path variables exists and is a directory(not a file).',
            'notDir' => 'Make sure the path variables exists and is a not directory(not a file).' 
    ];
    
    /**
     * 断言状态设置
     *
     * @param boolean $booOpen            
     * @return void
     */
    public static function open($booOpen = true) {
        static::$booOpen = $booOpen;
    }
    
    /**
     * 返回开放状态
     *
     * @return boolean
     */
    public static function getOpen() {
        return static::$booOpen;
    }
    
    /**
     * trueExpression 断言
     *
     * < false,null,0 或空触发异常 >
     *
     * @param mixed $mixExpression            
     * @param string $strDescription            
     * @return void
     */
    public static function trueExpression($mixExpression, $strDescription = null) {
        return static::checkExpression_ ( $mixExpression, 'trueExpression', $strDescription );
    }
    
    /**
     * notTrueExpression 断言
     *
     * < 非 false,null,0 或空触发异常 >
     *
     * @param mixed $mixExpression            
     * @param string $strDescription            
     * @return void
     */
    public static function notTrueExpression($mixExpression, $strDescription = null) {
        return static::checkExpression_ ( ! $mixExpression, 'notTrueExpression', $strDescription );
    }
    
    /**
     * true 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function true($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( $mixVariable === true, 'true', $strDescription );
    }
    
    /**
     * not true 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notTrue($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( $mixVariable === false, 'notTrue', $strDescription );
    }
    
    /**
     * null 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function null($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( $mixVariable === null, 'null', $strDescription );
    }
    
    /**
     * not null 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notNull($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( $mixVariable !== null, 'notNull', $strDescription );
    }
    
    /**
     * zero 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function zero($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( $mixVariable === 0 || $mixVariable === '0', 'zero', $strDescription );
    }
    
    /**
     * not zero 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notZero($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( $mixVariable !== 0 && $mixVariable !== '0', 'notZero', $strDescription );
    }
    
    /**
     * string zero 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function stringZero($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( $mixVariable === '0', 'stringZero', $strDescription );
    }
    
    /**
     * strict zero 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function strictZero($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( $mixVariable === 0, 'strictZero', $strDescription );
    }
    
    /**
     * not strict zero 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notStrictZero($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( $mixVariable !== 0, 'notStrictZero', $strDescription );
    }
    
    /**
     * string empty 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function stringEmpty($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( $mixVariable === '', 'stringEmpty', $strDescription );
    }
    
    /**
     * not string empty 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notStringEmpty($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( $mixVariable !== '', 'notStringEmpty', $strDescription );
    }
    
    /**
     * integer 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function integer($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( is_int ( $mixVariable ), 'integer', $strDescription );
    }
    
    /**
     * not integer 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notInteger($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( ! is_int ( $mixVariable ), 'notInteger', $strDescription );
    }
    
    /**
     * float 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function float($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( is_float ( $mixVariable ), 'float', $strDescription );
    }
    
    /**
     * not float 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notFloat($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( ! is_float ( $mixVariable ), 'notFloat', $strDescription );
    }
    
    /**
     * numeric 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function numeric($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( is_numeric ( $mixVariable ), 'numeric', $strDescription );
    }
    
    /**
     * not numeric 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notNumeric($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( ! is_numeric ( $mixVariable ), 'notNumeric', $strDescription );
    }
    
    /**
     * string 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function string($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( is_string ( $mixVariable ), 'string', $strDescription );
    }
    
    /**
     * not string 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notString($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( ! is_string ( $mixVariable ), 'notString', $strDescription );
    }
    
    /**
     * scalar 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function scalar($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( is_scalar ( $mixVariable ), 'scalar', $strDescription );
    }
    
    /**
     * not scalar 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notScalar($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( ! is_scalar ( $mixVariable ), 'notScalar', $strDescription );
    }
    
    /**
     * resource 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function resource($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( is_resource ( $mixVariable ), 'resource', $strDescription );
    }
    
    /**
     * not resource 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notResource($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( ! is_resource ( $mixVariable ), 'notResource', $strDescription );
    }
    
    /**
     * object 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function object($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( is_object ( $mixVariable ), 'object', $strDescription );
    }
    
    /**
     * not object 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notObject($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( ! is_object ( $mixVariable ), 'notObject', $strDescription );
    }
    
    /**
     * callback 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function callback($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( is_callable ( $mixVariable ), 'callback', $strDescription );
    }
    
    /**
     * not callback 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notCallback($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( ! is_callable ( $mixVariable ), 'notCallback', $strDescription );
    }
    
    /**
     * boolean 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function boolean($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( is_bool ( $mixVariable ), 'boolean', $strDescription );
    }
    
    /**
     * not boolean 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notBoolean($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( ! is_bool ( $mixVariable ), 'notBoolean', $strDescription );
    }
    
    /**
     * is array 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function isArray($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( is_array ( $mixVariable ), 'isArray', $strDescription );
    }
    
    /**
     * not is array 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notIsArray($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( ! is_array ( $mixVariable ), 'notIsArray', $strDescription );
    }
    
    /**
     * path 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function path($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( file_exists ( $mixVariable ), 'path', $strDescription );
    }
    
    /**
     * not path 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notPath($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( ! file_exists ( $mixVariable ), 'notPath', $strDescription );
    }
    
    /**
     * file 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function file($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( file_exists ( $mixVariable ), 'file', $strDescription );
    }
    
    /**
     * not file 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notFile($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( ! file_exists ( $mixVariable ), 'notFile', $strDescription );
    }
    
    /**
     * dir 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function dir($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( is_dir ( $mixVariable ), 'dir', $strDescription );
    }
    
    /**
     * not dir 断言
     *
     * @param mixed $mixVariable            
     * @param string $strDescription            
     * @return void
     */
    public static function notDir($mixVariable, $strDescription = null) {
        return static::checkExpression_ ( ! is_dir ( $mixVariable ), 'notDir', $strDescription );
    }
    
    /**
     * 验证表达式
     *
     * @param mixed $mixExpression            
     * @return void
     */
    private static function checkExpression_($mixExpression, $strType, $strDescription = null) {
        if (static::$booOpen === false || $mixExpression)
            return true;
        static::throwException_ ( $strType, $strDescription );
    }
    
    /**
     * 断言验证失败抛出异常
     *
     * @param string $strType            
     * @param string $strDescription            
     * @return void
     */
    private static function throwException_($strType, $strDescription = null) {
        if (empty ( $strDescription ))
            $strDescription = static::$arrMessage [$strType];
        $strDescription = '[' . $strType . ']' . $strDescription;
        exceptions::invalidArgumentException ( $strDescription );
    }
}
