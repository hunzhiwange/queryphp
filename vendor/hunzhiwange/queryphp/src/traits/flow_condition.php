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
namespace Q\traits;

/**
 * 流程控制复用
 *
 * @author Xiangmin Liu
 */
trait flow_condition {
    
    /**
     * 逻辑代码是否处于条件表达式中
     *
     * @var boolean
     */
    protected $booInFlowCondition = false;
    
    /**
     * 条件表达式是否为真
     *
     * @var boolean
     */
    protected $booFlowConditionIsTrue = false;
    
    /**
     * 由继承的类在 __call 中调用此方法
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return $this
     */
    protected function flowConditionCall_($sMethod, $arrArgs) {
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
                    $this->setFlowCondition_ ( true, isset ( $arrArgs [0] ) ? ( bool ) $arrArgs [0] : false );
                    break;
                case 'else' :
                    $this->setFlowCondition_ ( true, ! $this->getFlowCondition_ ()[1] );
                    break;
                case 'endIf' :
                    $this->setFlowCondition_ ( false, false );
                    break;
            }
            return $this;
        }
        
        return false;
    }
    
    /**
     * 设置当前条件表达式状态
     *
     * @param boolean $booInFlowCondition            
     * @param boolean $booFlowConditionIsTrue            
     * @return void
     */
    protected function setFlowCondition_($booInFlowCondition, $booFlowConditionIsTrue) {
        $this->booInFlowCondition = $booInFlowCondition;
        $this->booFlowConditionIsTrue = $booFlowConditionIsTrue;
    }
    
    /**
     * 获取当前条件表达式状态
     *
     * @return array
     */
    protected function getFlowCondition_() {
        return [ 
                $this->booInFlowCondition,
                $this->booFlowConditionIsTrue 
        ];
    }
    
    /**
     * 验证一下条件表达式是否通过
     *
     * @return boolean
     */
    protected function checkFlowCondition_() {
        return $this->booInFlowCondition && ! $this->booFlowConditionIsTrue;
    }
}
