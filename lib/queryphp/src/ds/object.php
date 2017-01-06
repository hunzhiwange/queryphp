<?php
/*
 * [$QueryPHP] (C)QueryPHP.COM Since 2016.11.17.
 * 数组转对象
 *
 * <The old is doyouhaobaby.com since 2010.10.04.>
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.11.21
 * @since 1.0
 */
namespace Q\ds;

use Q;

/**
 * 数组转对象
 *
 * @since 2016年11月28日 上午1:06:50
 * @author dyhb
 */
class object implements Iterator, ArrayAccess, Countable {
    
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
     * 构造函数
     *
     * @param arra $arrObject            
     */
    public function __construct($arrObject = []) {
        $this->arrObject = $arrObject;
    }
    
    /**
     * call 魔术方法
     *
     * @param string $sMethod            
     * @param array $arrArgs            
     */
    public function __call($sMethod, $arrArgs) {
        Q::throwException ( sprintf ( 'Method %s is not implemented', $sMethod ) );
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
        $mixOld = $this->offsetGet ( $strKey );
        $this->arrObject [$strKey] = $mixValue;
        return $mixOld;
    }
    
    /**
     * 实现 unset($obj['hello'])
     *
     * @param string $strKey            
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
     */
    public function each() {
        $arrArgs = func_get_args ();
        if (empty ( $arrArgs [0] ) || ! is_callable ( $arrArgs [0] )) {
            Q::throwException ( 'The first parameter must be a callback' );
        }
        
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
     */
    public function prev() {
        $prev = prev ( $this->arrObject );
        $this->booValid = $prev !== false;
        return $prev;
    }
    
    /**
     * jquery.end
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
     */
    public function eq($sKey) {
        return $this->offsetGet ( $sKey );
    }
    
    /**
     * jquery.get
     *
     * @param string $sKey            
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
     */
    public function find($sKey) {
        return $this->offsetGet ( $sKey );
    }
    
    /**
     * jquery.first
     */
    public function first() {
        return $this->rewind ();
    }
    
    /**
     * jquery.last
     */
    public function last() {
        return $this->end ();
    }
    /**
     * jquery.is
     *
     * @param string $sKey            
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
     */
    public function not($sKey) {
        return $this->siblings ( $sKey );
    }
    
    /**
     * jquery.filter
     *
     * @param string $sKey            
     */
    public function filter($sKey) {
        return $this->siblings ( $sKey );
    }
    
    /**
     * jquer.size
     */
    public function size() {
        return $this->count ();
    }
    
    /**
     * 是否为空
     */
    public function isEmpty() {
        return empty ( $this->arrObject );
    }
    
    /**
     * 数据 map
     *
     * @param string $sKeyName            
     * @param mixed $mixValueName            
     * @return array:
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
}
