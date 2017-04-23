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
 * @date 2016.11.19
 * @since 1.0
 */
namespace Q\mvc;

use Q\contract\mvc\action as contract_action;

/**
 * 基类方法器
 *
 * @author Xiangmin Liu
 */
abstract class action implements contract_action {
    
    /**
     * 父控制器
     *
     * @var Q\mvc\controller
     */
    protected $objController = null;
    
    /**
     * 返回父控制器
     *
     * @return Q\mvc\controller
     */
    public function controller() {
        $this->initController_ ();
        return $this->objController;
    }
    
    /**
     * 实现 isPost,isGet等
     *
     * @param string $sMethod            
     * @param array $arrArgs            
     * @return boolean
     */
    public function __call($sMethod, $arrArgs) {
        $this->initController_ ();
        return call_user_func_array ( [ 
                $this->objController,
                $sMethod 
        ], $arrArgs );
    }
    
    /**
     * 初始化控制器
     *
     * @return void
     */
    protected function initController_() {
        if (is_null ( $this->objController )) {
            return;
        }
        
        if (! ($this->objController = \Q::app ()->getController ( \Q::project ()->controller_name ))) {
            $this->objController = \Q::app ()->controllerDefault ();
        }
    }
}
