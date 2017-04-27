<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 * 
 * ##########################################################
 * #   ____                          ______  _   _ ______   #
 * #  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  # 
 * # |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
 * #  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
 * #       \__   | \___ |_|    \__  || |    | | | || |      #
 * #     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
 * #                          |___ /  Since 2010.10.03      #
 * ##########################################################
 * 
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2016.11.21
 * @since 1.0
 */
namespace Q\queue;

use Q\contract\queue\stack_queue as contract_stack_queue;

/**
 * 队列和栈抽象类
 *
 * @author Xiangmin Liu
 */
abstract class stack_queue implements contract_stack_queue {
    
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
}
