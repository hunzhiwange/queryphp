<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\traits\flow;

<<<queryphp
##########################################################
#   ____                          ______  _   _ ______   #
#  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
# |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
#  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
#       \__   | \___ |_|    \__  || |    | | | || |      #
#     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
#                          |___ /  Since 2010.10.03      #
##########################################################
queryphp;

/**
 * 流程控制复用
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.13
 * @version 1.0
 */
trait control {
    
    /**
     * 逻辑代码是否处于条件表达式中
     *
     * @var boolean
     */
    protected $booInFlowControl = false;
    
    /**
     * 条件表达式是否为真
     *
     * @var boolean
     */
    protected $booFlowControlIsTrue = false;
    
    /**
     * 条件语句 ifs
     *
     * @param boolean $booValue            
     * @return $this
     */
    protected function ifs($booValue = false) {
        return $this->setFlowControl_ ( true, $booValue );
    }
    
    /**
     * 条件语句 elseIfs
     *
     * @param boolean $booValue            
     * @return $this
     */
    protected function elseIfs($booValue = false) {
        return $this->setFlowControl_ ( true, $booValue );
    }
    
    /**
     * 条件语句 elses
     *
     * @return $this
     */
    protected function elses() {
        return $this->setFlowControl_ ( true, ! $this->getFlowControl_ ()[1] );
    }
    
    /**
     * 条件语句 endIfs
     *
     * @return $this
     */
    protected function endIfs() {
        return $this->setFlowControl_ ( false, false );
    }
    
    /**
     * 设置当前条件表达式状态
     *
     * @param boolean $booInFlowControl            
     * @param boolean $booFlowControlIsTrue            
     * @return void
     */
    protected function setFlowControl_($booInFlowControl, $booFlowControlIsTrue) {
        $this->booInFlowControl = $booInFlowControl;
        $this->booFlowControlIsTrue = $booFlowControlIsTrue;
        return $this;
    }
    
    /**
     * 获取当前条件表达式状态
     *
     * @return array
     */
    protected function getFlowControl_() {
        return [ 
                $this->booInFlowControl,
                $this->booFlowControlIsTrue 
        ];
    }
    
    /**
     * 验证一下条件表达式是否通过
     *
     * @return boolean
     */
    protected function checkFlowControl_() {
        return $this->booInFlowControl && ! $this->booFlowControlIsTrue;
    }
}
