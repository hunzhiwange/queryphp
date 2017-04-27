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
 * @date 2017.04.23
 * @since 4.0
 */
namespace Q\contract\queue;

/**
 * stack_queue 接口
 *
 * @author Xiangmin Liu
 */
interface stack_queue {
    
    /**
     * 加载元素
     *
     * @param mixed $mixItem            
     * @return void
     */
    public function in($mixItem);
    
    /**
     * 释放元素
     *
     * @return mixed
     */
    public function out();
}
