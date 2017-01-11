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
 * 栈，后进先出
 *
 * @author Xiangmin Liu
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
