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
namespace Q\structure;

/**
 * 队列，先进先出
 *
 * @author Xiangmin Liu
 */
class queue extends stack_queue {
    
    /**
     * 入对
     *
     * @param mixed $mixItem            
     * @return void
     */
    public function in($mixItem) {
        array_unshift ( $this->arrElements, $mixItem );
    }
    
    /**
     * 出队
     *
     * @return mixed
     */
    public function out() {
        if (! $this->getLength ()) {
            return null;
        }
        return array_shift ( $this->arrElements );
    }
}
