<?php
/*
 * [$QueryPHP] (C)QueryPHP.COM Since 2016.11.17.
 * 队列和栈抽象类
 *
 * <The old is doyouhaobaby.com since 2010.10.04.>
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.11.21
 * @since 1.0
 */
namespace Q\ds;

/**
 * 队列和栈抽象类
 *
 * @since 2016年11月21日 上午1:34:37
 * @author dyhb
 */
abstract class stack_queue {
    
    /**
     * 元素集合
     *
     * @var array
     */
    protected $arrElements = [ ];
    
    /**
     * 删除元素
     *
     * @param int $nIdx            
     */
    public function remove($nIdx) {
        unset ( $this->arrElements [$nIdx] );
    }
    
    /**
     * 元素长度
     *
     * @return int
     */
    public function getLength() {
        return count ( $this->arrElements );
    }
    
    /**
     * 元素是否为空
     *
     * @return boolean
     */
    public function isEmpty() {
        return ($this->getLength () == 0);
    }
    
    /**
     * 重置指针到开始
     *
     * @return mixed
     */
    public function reset() {
        return reset ( $this->arrElements );
    }
    
    /**
     * 加载元素
     *
     * @param mixed $mixItem            
     */
    abstract public function in($mixItem);
    
    /**
     * 释放元素
     */
    abstract public function out();
}
