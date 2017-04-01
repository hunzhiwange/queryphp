<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2016.11.21
 * @since 1.0
 */
namespace Q\structure;

/**
 * 队列和栈抽象类
 *
 * @author Xiangmin Liu
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
     * @return void
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
     * @return void
     */
    abstract public function in($mixItem);
    
    /**
     * 释放元素
     *
     * @return mixed
     */
    abstract public function out();
}
