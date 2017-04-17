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
 * @date 2017.04.13
 * @since 4.0
 */
namespace Q\factory;

/**
 * 基础类复用
 *
 * @author Xiangmin Liu
 */
trait reuse {
    
    /**
     * 参数
     *
     * @var array
     */
    protected $arrArgs = [ ];
    
    /**
     * 返回事件参数
     *
     * @param boolean $booFirstArgs            
     * @return mixed
     */
    public function getArgs($booFirstArgs = true) {
        if ($booFirstArgs === true) {
            return isset ( $this->arrArgs [0] ) ? $this->arrArgs [0] : null;
        } else {
            return $this->arrArgs;
        }
    }
}
