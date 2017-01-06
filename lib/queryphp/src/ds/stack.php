<?php
/*
 * [$QueryPHP] (C)QueryPHP.COM Since 2016.11.17.
 * 栈，后进先出
 *
 * <The old is doyouhaobaby.com since 2010.10.04.>
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.11.21
 * @since 1.0
 */
namespace Q\ds;

/**
 * 栈，后进先出
 *
 * @since 2016年11月21日 上午1:34:37
 * @author dyhb
 */
class stack extends stack_queue {
    
    /**
     * 进栈
     *
     * @param mixed $mixItem            
     */
    public function in($Item) {
        $this->arrElements [] = &$Item;
    }
    
    /**
     * 出栈
     */
    public function out() {
        if (! $this->getLength ()) {
            return null;
        }
        
        return array_pop ( $this->arrElements );
    }
}
