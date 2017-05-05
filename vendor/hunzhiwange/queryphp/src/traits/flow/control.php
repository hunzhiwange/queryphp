<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\traits\flow;

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
     * 由继承的类在 __call 中调用此方法
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return $this
     */
    protected function flowControlCall_($sMethod, $arrArgs) {
        // 条件控制语句支持
        if (in_array ( $sMethod, [ 
                'if',
                'elseIf',
                'else',
                'endIf' 
        ] )) {
            switch ($sMethod) {
                case 'if' :
                case 'elseIf' :
                    $this->setFlowControl_ ( true, isset ( $arrArgs [0] ) ? ( bool ) $arrArgs [0] : false );
                    break;
                case 'else' :
                    $this->setFlowControl_ ( true, ! $this->getFlowControl_ ()[1] );
                    break;
                case 'endIf' :
                    $this->setFlowControl_ ( false, false );
                    break;
            }
            return $this;
        }
        
        return false;
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
