<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\datastruct\collection;

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

use Iterator;
use ArrayAccess;
use Countable;
use queryyetsimple\exception\exceptions;
use queryyetsimple\assert\assert;

/**
 * 数组转对象集合
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.21
 * @version 1.0
 */
class collection implements Iterator, ArrayAccess, Countable {
    
    /**
     * 元素合集
     *
     * @var array
     */
    private $arrObject = [ ];
    
    /**
     * 验证
     *
     * @var boolean
     */
    private $booValid = true;
    
    /**
     * 类型
     *
     * @var string
     */
    private $sType = '';
    
    /**
     * 构造函数
     *
     * @param arra $arrObject            
     * @return void
     */
    public function __construct($arrObject = [], $sType = '') {
        $this->sType = $sType;
        foreach ( $arrObject as $offset => $oObject ) {
            $this [$offset] = $oObject;
        }
        return $this;
    }
    
    /**
     * call 魔术方法
     *
     * @param string $sMethod            
     * @param array $arrArgs            
     * @return void
     */
    public function __call($sMethod, $arrArgs) {
        exceptions::badMethodCallException ();
    }
    
    /**
     * __get 魔术方法
     *
     * @param string $strKey            
     * @return mixed
     */
    public function __get($strKey) {
        if (array_key_exists ( $strKey, $this->arrObject )) {
            return $this->arrObject [$strKey];
        } else {
            return NULL;
        }
    }
    
    /**
     * __set 魔术方法
     *
     * @param string $sKey            
     * @param mixed $mixVal            
     * @return mixed
     */
    public function __set($sKey, $mixVal) {
        $this->checkType_ ( $mixVal );
        $mixOld = $this->__get ( $sKey );
        $this->arrObject [$sKey] = $mixVal;
        return $mixOld;
    }
    
    // ######################################################
    // ------------- 实现 Iterator 迭代器接口 start -------------
    // ######################################################
    
    /**
     * 当前元素
     *
     * @return mixed
     */
    public function current() {
        return current ( $this->arrObject );
    }
    
    /**
     * 当前 key
     *
     * @return mixed
     */
    public function key() {
        return key ( $this->arrObject );
    }
    
    /**
     * 下一个元素
     *
     * @return mixed
     */
    public function next() {
        $next = next ( $this->arrObject );
        $this->booValid = $next !== false;
        return $next;
    }
    
    /**
     * 指针重置
     *
     * @return mixed
     */
    public function rewind() {
        $first = reset ( $this->arrObject );
        $this->booValid = $first !== false;
        return $first;
    }
    
    /**
     * 验证
     *
     * @return boolean
     */
    public function valid() {
        return $this->booValid;
    }
    
    // ######################################################
    // --------------- 实现 Iterator 迭代器接口 end ---------------
    // ######################################################
    
    // ######################################################
    // -------------- 实现 ArrayAccess 接口 start --------------
    // ######################################################
    
    /**
     * 实现 isset( $obj['hello'] )
     *
     * @param string $strKey            
     * @return mixed
     */
    public function offsetExists($strKey) {
        return isset ( $this->arrObject [$strKey] );
    }
    
    /**
     * 实现 $strHello = $obj['hello']
     *
     * @param string $strKey            
     * @return mixed
     */
    public function offsetGet($strKey) {
        return isset ( $this->arrObject [$strKey] ) ? $this->arrObject [$strKey] : NULL;
    }
    
    /**
     * 实现 $obj['hello'] = 'world'
     *
     * @param string $strKey            
     * @param mixed $mixValue            
     * @return mixed
     */
    public function offsetSet($strKey, $mixValue) {
        $this->checkType_ ( $mixValue );
        $mixOld = $this->offsetGet ( $strKey );
        $this->arrObject [$strKey] = $mixValue;
        return $mixOld;
    }
    
    /**
     * 实现 unset($obj['hello'])
     *
     * @param string $strKey            
     * @return void
     */
    public function offsetUnset($strKey) {
        if (isset ( $this->arrObject [$strKey] ))
            unset ( $this->arrObject [$strKey] );
    }
    
    // ######################################################
    // -------------- 实现 ArrayAccess 接口 start --------------
    // ######################################################
    
    // ######################################################
    // --------------- 实现 Countable 接口 start ---------------
    // ######################################################
    
    /**
     * 统计元素数量 count($obj)
     *
     * @return int
     */
    public function count() {
        return count ( $this->arrObject );
    }
    
    // ######################################################
    // ---------------- 实现 Countable 接口 end ----------------
    // ######################################################
    
    // ######################################################
    // ------------------ 实现额外的方法 start ------------------
    // ######################################################
    
    /**
     * jquery.each
     *
     * @return void
     */
    public function each() {
        $arrArgs = func_get_args ();
        assert::callback ( $arrArgs [0] );
        if (! empty ( $arrArgs [1] ) && is_string ( $arrArgs [1] )) {
            $sKeyName = $arrArgs [1];
        } else {
            $sKeyName = 'key';
        }
        
        $arrObject = $this->arrObject;
        foreach ( $arrObject as $key => $val ) {
            if (is_array ( $val )) {
                $arrData = $val;
                $arrData [$sKeyName] = $key;
            } else {
                $arrData = [ 
                        $sKeyName => $key,
                        'value' => $val 
                ];
            }
            $arrArgs [0] ( new self ( $arrData ) );
        }
    }
    
    /**
     * jquery.prev
     *
     * @return mixed
     */
    public function prev() {
        $prev = prev ( $this->arrObject );
        $this->booValid = $prev !== false;
        return $prev;
    }
    
    /**
     * jquery.end
     *
     * @return mixed
     */
    public function end() {
        $end = end ( $this->arrObject );
        $this->booValid = $end !== false;
        return $end;
    }
    
    /**
     * jquery.siblings
     *
     * @param mixed $mixCurrentKey            
     * @return array
     */
    public function siblings($mixCurrentKey = NULL) {
        $arrSiblings = [ ];
        $mixCurrentKey === NULL && $mixCurrentKey = $this->key ();
        if (! is_array ( $mixCurrentKey )) {
            $mixCurrentKey [] = $mixCurrentKey;
        }
        $arrObject = $this->arrObject;
        foreach ( $arrObject as $sKey => $mixVal ) {
            if (in_array ( $sKey, $mixCurrentKey )) {
                continue;
            }
            $arrSiblings [$sKey] = $mixVal;
        }
        unset ( $arrObject );
        return $arrSiblings;
    }
    
    /**
     * jquery.nextAll
     *
     * @param mixed $mixCurrentKey            
     * @return array
     */
    public function nextAll($mixCurrentKey = NULL) {
        $arrNexts = [ ];
        $mixCurrentKey === NULL && $mixCurrentKey = $this->key ();
        $arrObject = $this->arrObject;
        $booCurrent = false;
        foreach ( $arrObject as $sKey => $mixVal ) {
            if ($booCurrent === false) {
                if ($mixCurrentKey === $sKey) {
                    $booCurrent = true;
                }
                continue;
            }
            $arrNexts [$sKey] = $mixVal;
        }
        unset ( $arrObject );
        return $arrNexts;
    }
    
    /**
     * jquery.prevAll
     *
     * @param mixed $mixCurrentKey            
     * @return array
     */
    public function prevAll($mixCurrentKey = NULL) {
        $arrPrevs = [ ];
        $mixCurrentKey === NULL && $mixCurrentKey = $this->key ();
        $arrObject = $this->arrObject;
        $booCurrent = false;
        foreach ( $arrObject as $sKey => $mixVal ) {
            if ($mixCurrentKey === $sKey) {
                $booCurrent = true;
                break;
            }
            $arrPrevs [$sKey] = $mixVal;
        }
        unset ( $arrObject );
        return $arrPrevs;
    }
    
    /**
     * jquery.attr
     *
     * @param string $sKey            
     * @param mixed $mixValue            
     * @return void|mixed
     */
    public function attr($sKey, $mixValue = null) {
        if ($mixValue === null) {
            return $this->__get ( $sKey );
        } else {
            $this->__set ( $sKey, $mixValue );
        }
    }
    
    /**
     * jquery.eq
     *
     * @param string $sKey            
     * @return mixed
     */
    public function eq($sKey) {
        return $this->offsetGet ( $sKey );
    }
    
    /**
     * jquery.get
     *
     * @param string $sKey            
     * @return mixed
     */
    public function get($sKey) {
        return $this->offsetGet ( $sKey );
    }
    
    /**
     * jquery.index
     *
     * @param mixed $mixValue            
     * @return mixed
     */
    public function index($mixValue = null) {
        if ($mixValue === null) {
            return $this->key ();
        } else {
            $sKey = array_search ( $mixValue, $this->arrObject );
            if ($sKey === false) {
                return null;
            }
            return $sKey;
        }
    }
    
    /**
     * jquery.find
     *
     * @param string $sKey            
     * @return mixed
     */
    public function find($sKey) {
        return $this->offsetGet ( $sKey );
    }
    
    /**
     * jquery.first
     *
     * @return mixed
     */
    public function first() {
        return $this->rewind ();
    }
    
    /**
     * jquery.last
     *
     * @return mixed
     */
    public function last() {
        return $this->end ();
    }
    /**
     * jquery.is
     *
     * @param string $sKey            
     * @return boolean
     */
    public function is($sKey) {
        return $this->offsetExists ( $sKey );
    }
    
    /**
     * jquery.slice
     *
     * @param int $nSelector            
     * @param string $nEnd            
     * @return array
     */
    public function slice($nSelector, $nEnd = NULL) {
        if ($nEnd === NULL) {
            return array_slice ( $this->arrObject, $nSelector );
        } else {
            return array_slice ( $this->arrObject, $nSelector, $nEnd );
        }
    }
    
    /**
     * jquery.not
     *
     * @param string $sKey            
     * @return array
     */
    public function not($sKey) {
        return $this->siblings ( $sKey );
    }
    
    /**
     * jquery.filter
     *
     * @param string $sKey            
     * @return array
     */
    public function filter($sKey) {
        return $this->siblings ( $sKey );
    }
    
    /**
     * jquer.size
     *
     * @return int
     */
    public function size() {
        return $this->count ();
    }
    
    /**
     * 是否为空
     *
     * @return boolean
     */
    public function isEmpty() {
        return empty ( $this->arrObject );
    }
    
    /**
     * 数据 map
     *
     * @param string $sKeyName            
     * @param mixed $mixValueName            
     * @return array
     */
    public function map($sKeyName, $mixValueName = null) {
        if ($mixValueName === NULL) {
            return array_column ( $this->arrObject, null, $sKeyName );
        } elseif ($mixValueName === true) {
            return array_column ( $this->arrObject, $sKeyName );
        } else {
            return array_column ( $this->arrObject, $mixValueName, $sKeyName );
        }
    }
    
    // ######################################################
    // ------------------- 实现额外的方法 end -------------------
    // ######################################################
    
    /**
     * 验证类型
     *
     * @param mixed $mixObject            
     * @return void
     */
    private function checkType_($mixObject) {
        if (is_object ( $mixObject )) {
            if ($mixObject instanceof $this->sType) {
                return;
            }
            $sType = get_class ( $mixObject );
        } else {
            $sType = gettype ( $mixObject );
        }
        
        exceptions::invalidArgumentException ();
    }
}
