<?php
/*
 * [$QueryPHP] (C)QueryPHP.COM Since 2016.11.17.
 * 队列，先进先出
 *
 * <The old is doyouhaobaby.com since 2010.10.04.>
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.11.21
 * @since 1.0
 */
namespace Q\ds;

/**
 * 队列，先进先出
 *
 * @since 2016年11月21日 上午1:34:37
 * @author dyhb
 */
class queue extends stack_queue {
    
    /**
     * 入对
     *
     * @param mixed $mixItem            
     */
    public function in($mixItem) {
        array_unshift ( $this->arrElements, $mixItem );
    }
    
    /**
     * 出队
     */
    public function out() {
        if (! $this->getLength ()) {
            return null;
        }
        
        return array_shift ( $this->arrElements );
    }
}
